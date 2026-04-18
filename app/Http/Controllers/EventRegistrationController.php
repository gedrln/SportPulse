<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventRegistrationController extends Controller {
    
    public function index() {
        if (auth()->user()->isAdmin()) {
            $registrations = EventRegistration::with(['user', 'event'])->latest()->paginate(15);
        } else {
            $registrations = EventRegistration::with('event')
                ->where('user_name', auth()->user()->username)
                ->latest()
                ->paginate(15);
        }
        return view('registrations.index', compact('registrations'));
    }

    public function create(Request $request) {
        // Get all upcoming events that are not full
        $events = Event::where('status', 'upcoming')
            ->whereRaw('participants < max_participants')
            ->orderBy('event_date')
            ->get();
        
        // If no events found, get all upcoming events
        if ($events->isEmpty()) {
            $events = Event::where('status', 'upcoming')->orderBy('event_date')->get();
        }
        
        $selectedEvent = null;
        if ($request->event_id) {
            $selectedEvent = Event::where('event_id', $request->event_id)->first();
        }
        
        return view('registrations.create', compact('events', 'selectedEvent'));
    }

    public function store(Request $request) {
        // Validate the request
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'participant_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        $eventId = $request->event_id;
        $username = auth()->user()->username;

        // Check if user is already registered for this event
        $alreadyRegistered = EventRegistration::where('user_name', $username)
            ->where('event_id', $eventId)
            ->exists();
            
        if ($alreadyRegistered) {
            return back()->with('error', 'You are already registered for this event.')->withInput();
        }

        // Get the event
        $event = Event::where('event_id', $eventId)->firstOrFail();
        
        // Check if event is full
        if ($event->participants >= $event->max_participants) {
            return back()->with('error', 'Sorry, this event is already full.')->withInput();
        }

        // Create registration
        EventRegistration::create([
            'user_name' => $username,
            'event_id' => $eventId,
            'registration_date' => Carbon::now(),
            'participant_name' => $request->participant_name,
            'contact_number' => $request->contact_number,
            'status' => 'pending',
        ]);

        return redirect()->route('registrations.index')
            ->with('success', 'Registration submitted! Waiting for admin approval.');
    }

    public function approve(EventRegistration $registration) {
        $event = $registration->event;
        if ($event->participants >= $event->max_participants) {
            return back()->with('error', 'Event is full!');
        }
        $registration->update(['status' => 'approved']);
        $event->increment('participants');
        return back()->with('success', 'Registration approved!');
    }

    public function reject(EventRegistration $registration) {
        $registration->update(['status' => 'rejected']);
        return back()->with('success', 'Registration rejected.');
    }

    public function destroy(EventRegistration $registration) {
        if ($registration->status == 'approved') {
            $registration->event->decrement('participants');
        }
        $registration->delete();
        return redirect()->route('registrations.index')
            ->with('success', 'Registration deleted.');
    }

    public function cancel(EventRegistration $registration) {
        if ($registration->user_name !== auth()->user()->username) {
            abort(403);
        }
        if ($registration->status !== 'pending') {
            return back()->with('error', 'You can only cancel pending registrations.');
        }
        $registration->delete();
        return redirect()->route('registrations.index')
            ->with('success', 'Registration cancelled.');
    }
}