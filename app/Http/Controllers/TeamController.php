<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class TeamController extends Controller {

    public function index(Event $event) {
        $event->load('teams.registrations.user', 'registrations.user');
        $unassigned = $event->registrations()
            ->whereNull('team_id')
            ->where('status', 'approved')
            ->with('user')
            ->get();

        return view('teams.index', compact('event', 'unassigned'));
    }

    public function store(Request $request, Event $event) {
        $validated = $request->validate([
            'team_name' => 'required|string|max:100',
            'team_size' => 'required|integer|min:1|max:50',
        ]);

        $event->teams()->create($validated);

        return back()->with('success', 'Team created successfully!');
    }

    public function assign(Request $request, Event $event) {
        $request->validate([
            'registration_id' => 'required|exists:events_registrations,registration_id',
            'team_id'         => 'required|exists:teams,team_id',
        ]);

        $registration = EventRegistration::findOrFail($request->registration_id);
        $team = Team::findOrFail($request->team_id);

        // Check team belongs to this event
        if ($team->event_id != $event->event_id) {
            return back()->with('error', 'Team does not belong to this event.');
        }

        // Check team is not full
        if ($team->isFull()) {
            return back()->with('error', "Team \"{$team->team_name}\" is full ({$team->team_size} players max).");
        }

        $registration->update(['team_id' => $team->team_id]);

        return back()->with('success', 'Player assigned to team!');
    }

    public function unassign(Event $event, EventRegistration $registration) {
        $registration->update(['team_id' => null]);
        return back()->with('success', 'Player removed from team.');
    }

    public function destroy(Event $event, Team $team) {
        // Unassign all players first
        $team->registrations()->update(['team_id' => null]);
        $team->delete();
        return back()->with('success', 'Team deleted.');
    }

    public function validateTeams(Event $event) {
        $teams = $event->teams()->with('registrations')->get();

        if ($teams->count() < 2) {
            return back()->with('error', 'You need at least 2 teams to validate.');
        }

        $sizes = $teams->map(fn($t) => $t->approvedCount());
        $allEqual = $sizes->unique()->count() === 1;

        if (!$allEqual) {
            $summary = $teams->map(fn($t) => "\"{$t->team_name}\": {$t->approvedCount()} players")->join(', ');
            return back()->with('error', "Teams must have equal players. Current: {$summary}.");
        }

        return back()->with('success', 'All teams are balanced and ready!');
    }
}