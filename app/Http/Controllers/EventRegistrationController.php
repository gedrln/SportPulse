<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventRegistrationController extends Controller {
    
    public function index() {
        if (auth()->user()->isAdmin()) {
            $pending   = EventRegistration::with(['user', 'event'])->where('status', 'pending')->latest()->get();
            $approved  = EventRegistration::with(['user', 'event'])->where('status', 'approved')->latest()->get();
            $rejected  = collect(); // admin sees rejected inside Archived tab
            $cancelled = EventRegistration::with(['user', 'event'])->where('status', 'cancelled')->latest()->get();
            $archived  = EventRegistration::with(['user', 'event'])->whereIn('status', ['archived', 'rejected'])->latest()->get();
        } else {
            $pending   = EventRegistration::with('event')->where('user_name', auth()->user()->username)->where('status', 'pending')->latest()->get();
            $approved  = EventRegistration::with('event')->where('user_name', auth()->user()->username)->where('status', 'approved')->latest()->get();
            $rejected  = EventRegistration::with('event')->where('user_name', auth()->user()->username)->where('status', 'rejected')->latest()->get();
            $cancelled = EventRegistration::with('event')->where('user_name', auth()->user()->username)->where('status', 'cancelled')->latest()->get();
            $archived  = collect();
        }

        return view('registrations.index', compact('pending', 'approved', 'rejected', 'cancelled', 'archived'));
    }

    public function create(Request $request) {
        $events = Event::where('status', 'upcoming')
            ->whereRaw('participants < max_participants')
            ->orderBy('event_date')
            ->get();
        
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
        $request->validate([
            'event_id'         => 'required|exists:events,event_id',
            'participant_name' => 'required|string|max:255',
            'contact_number'   => 'required|string|max:20',
        ]);

        $eventId  = $request->event_id;
        $username = auth()->user()->username;

        $alreadyRegistered = EventRegistration::where('user_name', $username)
            ->where('event_id', $eventId)
            ->exists();
            
        if ($alreadyRegistered) {
            return back()->with('error', 'You are already registered for this event.')->withInput();
        }

        $event = Event::where('event_id', $eventId)->firstOrFail();
        
        if ($event->participants >= $event->max_participants) {
            return back()->with('error', 'Sorry, this event is already full.')->withInput();
        }

        EventRegistration::create([
            'user_name'         => $username,
            'event_id'          => $eventId,
            'registration_date' => Carbon::now(),
            'participant_name'  => $request->participant_name,
            'contact_number'    => $request->contact_number,
            'status'            => 'pending',
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
        return back()->with('success', 'Registration rejected and moved to archive.');
    }

    public function archive(EventRegistration $registration) {
        if ($registration->status == 'approved') {
            $registration->event->decrement('participants');
        }
        $registration->update(['status' => 'archived']);
        return back()->with('success', 'Registration archived.');
    }

    public function cancel(EventRegistration $registration) {
        if ($registration->user_name !== auth()->user()->username) {
            abort(403);
        }
        if ($registration->status !== 'pending') {
            return back()->with('error', 'You can only cancel pending registrations.');
        }
        $registration->update(['status' => 'cancelled']);
        return redirect()->route('registrations.index')
            ->with('success', 'Registration cancelled.');
    }
}