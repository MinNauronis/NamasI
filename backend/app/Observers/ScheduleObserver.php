<?php

namespace App\Observers;


use App\Schedule;
use App\Weekday;

class ScheduleObserver
{
    public function created(Schedule $schedule)
    {
        $this->createSevenDays($schedule);
    }

    public function deleting(Schedule $schedule)
    {
        $this->deleteDays($schedule);
    }

    private function createSevenDays(Schedule $schedule): void
    {
        for ($i = 0; $i < 7; $i++) {
            $weekday = new Weekday();
            $weekday->weekday = $i;
            $weekday->owner_id = $schedule->owner_id;
            $weekday->schedule_id = $schedule->id;
            $weekday->save();
        }
    }

    private function deleteDays(Schedule $schedule): void
    {
        $days = $schedule->weekdays;

        foreach ($days as $day) {
            $day->delete();
        }
    }
}
