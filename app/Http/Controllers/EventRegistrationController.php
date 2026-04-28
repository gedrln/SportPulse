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
            $rejected  = EventRegistration::with(['user', 'event'])->where('status', 'rejected')->latest()->get();
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
        // Only show events that still have available slots (based on active registrations)
        $events = Event::where('status', 'upcoming')
            ->get()
            ->filter(fn($e) => $e->availableSlots() > 0)
            ->values();

        if ($events->isEmpty()) {
            $events = Event::where('status', 'upcoming')->get();
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

        // Check if already registered for this specific event (active only)
        $alreadyRegistered = EventRegistration::where('user_name', $username)
            ->where('event_id', $eventId)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'You are already registered for this event.')->withInput();
        }

        $event = Event::where('event_id', $eventId)->firstOrFail();

        // Block if event is not upcoming
        if ($event->status !== 'upcoming') {
            return back()->with('error', 'Registration is closed. This event is currently ' . ucfirst($event->status) . '.')->withInput();
        }

        // Block if no available slots (pending + approved >= max)
        if ($event->isFull()) {
            return back()->with('error', 'Sorry, this event is already full. No more slots available.')->withInput();
        }

        // Block exact same time conflict
        $sameTimeCount = EventRegistration::where('user_name', $username)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->whereHas('event', function ($q) use ($event) {
                $q->where('event_date', $event->event_date);
            })
            ->count();

        if ($sameTimeCount >= 1) {
            return back()->with('error',
                'You already have an event at ' .
                $event->event_date->format('M d, Y g:i A') .
                '. You cannot register for two events at the exact same time.'
            )->withInput();
        }

        // Block more than 2 on same date
        $sameDateCount = EventRegistration::where('user_name', $username)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->whereHas('event', function ($q) use ($event) {
                $q->whereDate('event_date', $event->event_date->toDateString());
            })
            ->count();

        if ($sameDateCount >= 2) {
            return back()->with('error',
                'You already have ' . $sameDateCount . ' event(s) on ' .
                $event->event_date->format('M d, Y') .
                '. You cannot register for more than 2 events on the same date.'
            )->withInput();
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

        // Only check approved count vs max for final approval
        if ($event->approvedCount() >= $event->max_participants) {
            return back()->with('error', 'Cannot approve — event is already full!');
        }

        $registration->update(['status' => 'approved']);

        // Sync participants count with approved count
        $event->syncParticipants();

        return back()->with('success', 'Registration approved!');
    }

    public function reject(EventRegistration $registration) {
        $registration->update(['status' => 'rejected']);
        // Sync in case it was previously approved
        $registration->event->syncParticipants();
        return back()->with('success', 'Registration rejected and moved to archive.');
    }

    public function archive(EventRegistration $registration) {
        $registration->update(['status' => 'archived', 'team_id' => null]);
        $registration->event->syncParticipants();
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
        $registration->event->syncParticipants();
        return redirect()->route('registrations.index')
            ->with('success', 'Registration cancelled.');
    }
}