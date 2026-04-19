<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller {

    // All supported sport types — always shown in filter regardless of DB contents
    const SPORT_TYPES = [
        'Basketball',
        'Football',
        'Volleyball',
        'Swimming',
        'Running',
        'Badminton',
        'Pickle Ball',
        'Tennis',
    ];

    public function index(Request $request) {
        $query = Event::query();

        if ($request->filled('sport_type')) {
            $query->where('sport_type', $request->sport_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->orderBy('event_date')->paginate(9);

        // Merge hardcoded list with any extra types already in DB
        $dbSports = Event::distinct()->pluck('sport_type')->filter()->values()->toArray();
        $sportTypes = collect(self::SPORT_TYPES)
            ->merge($dbSports)
            ->unique()
            ->sort()
            ->values();

        return view('events.index', compact('events', 'sportTypes'));
    }

    public function show(Event $event) {
        $event->load('registrations');
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
        $validated = $request->validate([
            'event_name'       => 'required|string|max:255',
            'location'         => 'required|string|max:255',
            'event_date'       => 'required|date|after:now',
            'event_end_date'   => 'nullable|date|after:event_date',
            'max_participants' => 'required|integer|min:1',
            'sport_type'       => 'required|string',
            'description'      => 'nullable|string',
            'status'           => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $validated['participants'] = 0;
        $validated['created_by'] = auth()->id();

        Event::create($validated);

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
            'max_participants' => 'required|integer|min:1',
            'sport_type'       => 'required|string',
            'description'      => 'nullable|string',
            'status'           => 'required|in:upcoming,ongoing,completed,cancelled',
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