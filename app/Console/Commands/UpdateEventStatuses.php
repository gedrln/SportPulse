<?php
namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateEventStatuses extends Command {
    protected $signature   = 'events:update-statuses';
    protected $description = 'Auto-update event statuses based on date';

    public function handle() {
        $now = Carbon::now();

        // Upcoming → Ongoing (event has started)
        Event::where('status', 'upcoming')
            ->where('event_date', '<=', $now)
            ->each(function ($event) use ($now) {
                $endDate = $event->event_end_date ?? $event->event_date->copy()->endOfDay();
                if ($now->lessThanOrEqualTo($endDate)) {
                    $event->update(['status' => 'ongoing']);
                }
            });

        // Ongoing → Completed (event has ended)
        Event::where('status', 'ongoing')
            ->each(function ($event) use ($now) {
                $endDate = $event->event_end_date ?? $event->event_date->copy()->endOfDay();
                if ($now->greaterThan($endDate)) {
                    $event->update(['status' => 'completed']);
                }
            });

        // Upcoming → Completed (no end date, event_date passed end of day)
        Event::where('status', 'upcoming')
            ->whereNull('event_end_date')
            ->where('event_date', '<', $now->copy()->startOfDay())
            ->each(function ($event) {
                $event->update(['status' => 'completed']);
            });

        $this->info('Event statuses updated successfully.');
    }
}