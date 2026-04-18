<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller {
    
    // Display all events with sport type filtering
    public function index(Request $request) {
        $query = Event::query();
        
        // Filter by sport type if selected
        if ($request->has('sport') && $request->sport != '') {
            $query->where('sport_type', $request->sport);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'upcoming');
        }
        
        $events = $query->orderBy('event_date')->paginate(9);
        
        // Get all unique sport types for filter dropdown
        $sports = Event::distinct()->pluck('sport_type')->filter()->values();
        
        return view('events.index', compact('events', 'sports'));
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
            'event_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date|after:now',
            'max_participants' => 'required|integer|min:1',
            'sport_type' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
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
            'event_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'max_participants' => 'required|integer|min:1',
            'sport_type' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
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