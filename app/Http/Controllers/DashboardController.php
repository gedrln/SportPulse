<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;

class DashboardController extends Controller {
    public function index() {
        $isAdmin = auth()->user()->isAdmin();
        $totalEvents = Event::count();
        $upcomingEvents = Event::where('status', 'upcoming')->count();

        if ($isAdmin) {
            $totalRegistrations = EventRegistration::count();
            $pendingRegistrations = EventRegistration::where('status', 'pending')->count();
            $totalUsers = User::count();
            $recentEvents = Event::where('status', 'upcoming')->orderBy('event_date')->take(5)->get();
            $latestRegistrations = EventRegistration::with(['user', 'event'])->latest()->take(8)->get();
            
            $monthlyRegistrations = array_fill(0, 12, 0);
            $raw = EventRegistration::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')->get();
            foreach ($raw as $r) {
                $monthlyRegistrations[$r->month - 1] = $r->total;
            }

            return view('dashboard', compact(
                'isAdmin', 'totalEvents', 'upcomingEvents', 'totalRegistrations',
                'pendingRegistrations', 'totalUsers', 'recentEvents', 'latestRegistrations', 'monthlyRegistrations'
            ));
        } else {
            $myRegistrations = EventRegistration::with('event')
                ->where('user_name', auth()->user()->username)
                ->latest()
                ->take(6)
                ->get();
            
            $myApproved = EventRegistration::where('user_name', auth()->user()->username)
                ->where('status', 'approved')
                ->count();
            
            $myPending = EventRegistration::where('user_name', auth()->user()->username)
                ->where('status', 'pending')
                ->count();
            
            $recentEvents = Event::where('status', 'upcoming')
                ->orderBy('event_date')
                ->take(4)
                ->get();

            return view('dashboard', compact(
                'isAdmin', 'totalEvents', 'upcomingEvents',
                'myRegistrations', 'myApproved', 'myPending', 'recentEvents'
            ));
        }
    }
}