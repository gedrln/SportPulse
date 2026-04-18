<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function index(Request $request) {
        $isAdmin = auth()->user()->isAdmin();
        $totalEvents = Event::count();
        $upcomingEvents = Event::where('status', 'upcoming')->count();

        if ($isAdmin) {
            $totalRegistrations = EventRegistration::count();
            $pendingRegistrations = EventRegistration::where('status', 'pending')->count();
            $totalUsers = User::count();
            $recentEvents = Event::where('status', 'upcoming')->orderBy('event_date')->take(5)->get();
            $latestRegistrations = EventRegistration::with(['user', 'event'])->latest()->take(8)->get();

            $selectedYear  = $request->get('year', now()->year);
            $selectedMonth = $request->get('month', '');

            if ($selectedMonth !== '') {
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
                $dailyRegistrations = array_fill(1, $daysInMonth, 0);

                $raw = EventRegistration::selectRaw('DAY(created_at) as day, COUNT(*) as total')
                    ->whereYear('created_at', $selectedYear)
                    ->whereMonth('created_at', $selectedMonth)
                    ->groupBy('day')
                    ->get();

                foreach ($raw as $r) {
                    $dailyRegistrations[$r->day] = $r->total;
                }

                $chartLabels = array_map(fn($d) => "$d", array_keys($dailyRegistrations));
                $chartData   = array_values($dailyRegistrations);
                $chartTitle  = date('F', mktime(0, 0, 0, $selectedMonth, 1)) . " $selectedYear";
            } else {
                $monthlyRegistrations = array_fill(0, 12, 0);

                $raw = EventRegistration::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                    ->whereYear('created_at', $selectedYear)
                    ->groupBy('month')
                    ->get();

                foreach ($raw as $r) {
                    $monthlyRegistrations[$r->month - 1] = $r->total;
                }

                $chartLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                $chartData   = $monthlyRegistrations;
                $chartTitle  = "All Months $selectedYear";
            }

            $availableYears = EventRegistration::selectRaw('YEAR(created_at) as year')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();

            if (!in_array(now()->year, $availableYears)) {
                array_unshift($availableYears, now()->year);
            }

            return view('dashboard', compact(
                'isAdmin', 'totalEvents', 'upcomingEvents', 'totalRegistrations',
                'pendingRegistrations', 'totalUsers', 'recentEvents', 'latestRegistrations',
                'chartLabels', 'chartData', 'chartTitle',
                'selectedYear', 'selectedMonth', 'availableYears'
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

            // Upcoming event notifications (approved registrations within 7 days)
            $upcomingNotifications = EventRegistration::with('event')
                ->where('user_name', auth()->user()->username)
                ->where('status', 'approved')
                ->whereHas('event', function($q) {
                    $q->whereBetween('event_date', [now()->startOfDay(), now()->addDays(7)->endOfDay()]);
                })
                ->get()
                ->map(function($r) {
                    $r->days_left = now()->startOfDay()->diffInDays($r->event->event_date->startOfDay());
                    return $r;
                });

            return view('dashboard', compact(
                'isAdmin', 'totalEvents', 'upcomingEvents',
                'myRegistrations', 'myApproved', 'myPending',
                'recentEvents', 'upcomingNotifications'
            ));
        }
    }
}