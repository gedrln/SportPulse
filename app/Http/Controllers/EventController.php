<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller {

    private function syncEventStatuses() {
        $now = Carbon::now();

        // Upcoming → Ongoing
        Event::where('status', 'upcoming')
            ->where('event_date', '<=', $now)
            ->each(function ($event) use ($now) {
                $endDate = $event->event_end_date ?? $event->event_date->copy()->endOfDay();
                if ($now->lessThanOrEqualTo($endDate)) {
                    $event->update(['status' => 'ongoing']);
                }
            });

        // Ongoing → Completed
        Event::where('status', 'ongoing')
            ->each(function ($event) use ($now) {
                $endDate = $event->event_end_date ?? $event->event_date->copy()->endOfDay();
                if ($now->greaterThan($endDate)) {
                    $event->update(['status' => 'completed']);
                }
            });

        // Upcoming → Completed (passed end of day, no end date)
        Event::where('status', 'upcoming')
            ->whereNull('event_end_date')
            ->where('event_date', '<', $now->copy()->startOfDay())
            ->each(function ($event) {
                $event->update(['status' => 'completed']);
            });
    }

    public function index(Request $request) {
        $this->syncEventStatuses();

        $query = Event::query();

        if ($request->filled('sport_type')) {
            $query->where('sport_type', $request->sport_type);
        }

        // If a specific status is filtered, pass a flat collection instead of grouped
        $filterStatus = $request->filled('status') ? $request->status : null;

        if ($filterStatus) {
            $query->where('status', $filterStatus);
            $events = $query->orderBy('event_date')->get();
            $groupedEvents = null;
        } else {
            $allEvents = $query->orderBy('event_date')->get();
            $groupedEvents = [
                'upcoming'  => $allEvents->where('status', 'upcoming')->values(),
                'ongoing'   => $allEvents->where('status', 'ongoing')->values(),
                'completed' => $allEvents->where('status', 'completed')->values(),
            ];
            $events = null;
        }

        $sportTypes = Event::distinct()->pluck('sport_type')->filter()->values();

        return view('events.index', compact('events', 'groupedEvents', 'sportTypes', 'filterStatus'));
    }

    public function show(Event $event) {
        $this->syncEventStatuses();

        $event->refresh();
        $event->load('registrations', 'teams');

        $alreadyRegistered = false;
        if (auth()->check() && !auth()->user()->isAdmin()) {
            $alreadyRegistered = $event->registrations()
                ->where('user_name', auth()->user()->username)
                ->exists();
        }
        return view('events.show', compact('event', 'alreadyRegistered'));
    }

    public function create() {
        return view('events.create');
    }

    public function store(Request $request) {
        $teamSports  = ['Basketball', 'Football', 'Volleyball', 'Badminton', 'Pickle Ball', 'Tennis'];
        $isTeamSport = in_array($request->sport_type, $teamSports);

        $rules = [
            'event_name'       => 'required|string|max:255',
            'location'         => 'required|string|max:255',
            'event_date'       => 'required|date|after:now',
            'event_end_date'   => 'nullable|date|after:event_date',
            'max_participants' => ['required', 'integer', function ($attribute, $value, $fail) {
                if ($value < 10) {
                    $fail('Maximum participants must be at least 10 players.');
                }
            }],
            'sport_type'  => 'required|string',
            'description' => 'nullable|string',
            'status'      => 'required|in:upcoming,ongoing,completed,cancelled',
        ];

        if ($isTeamSport) {
            $rules['teams']        = 'required|array|min:2';
            $rules['teams.*.name'] = 'required|string|max:100';
            $rules['teams.*.size'] = 'required|integer|min:1|max:50';
        }

        $validated = $request->validate($rules);

        if ($isTeamSport) {
            $teamSizes = collect($request->teams)->pluck('size')->map(fn($s) => (int)$s)->unique();
            if ($teamSizes->count() > 1) {
                return back()->withInput()
                    ->withErrors(['teams' => 'All teams must have equal player slots. Please balance the team sizes.']);
            }
        }

        $validated['participants'] = 0;
        $validated['created_by']   = auth()->id();

        $event = Event::create(collect($validated)->except('teams')->toArray());

        if ($isTeamSport && $request->teams) {
            foreach ($request->teams as $team) {
                $event->teams()->create([
                    'team_name' => $team['name'],
                    'team_size' => (int) $team['size'],
                ]);
            }
        }

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully!');
    }

    public function edit(Event $event) {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event) {
        $validated = $request->validate([
            'event_name'       => 'required|string|max:255',
            'location'         => 'required|string|max:255',
            'event_date'       => 'required|date',
            'event_end_date'   => 'nullable|date|after:event_date',
            'max_participants' => ['required', 'integer', function ($attribute, $value, $fail) {
                if ($value < 10) {
                    $fail('Maximum participants must be at least 10 players.');
                }
            }],
            'sport_type'  => 'required|string',
            'description' => 'nullable|string',
            'status'      => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event) {
        $event->delete();
        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }
}