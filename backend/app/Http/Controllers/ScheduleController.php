<?php

namespace App\Http\Controllers;

use App\Curtain;
use App\Schedule;
use App\Weekday;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function getAllAction(Request $request, Curtain $curtain)
    {
        $curtainId = $curtain->id;
        $schedules = Schedule::all()->where('curtain_id', $curtainId);
        return new JsonResponse(['schedules' => $schedules], JsonResponse::HTTP_OK);
    }

    public function getAction(Request $request, Curtain $curtain, Schedule $schedule)
    {
        return new JsonResponse(['schedule' => $schedule], JsonResponse::HTTP_OK);
    }

    public function postAction(Request $request, Curtain $curtain)
    {
        $schedule = $this->createSchedule($curtain, $request);

        return new JsonResponse(['schedule' => $schedule], JsonResponse::HTTP_CREATED);
    }

    public function putAction(Request $request, Curtain $curtain, Schedule $schedule)
    {
        $oldSchedule = clone $schedule;

        $schedule = $this->updateSchedule($schedule, $request);

        return new JsonResponse(
            ['schedule' => $schedule, 'oldSchedule' => $oldSchedule],
            JsonResponse::HTTP_OK);
    }

    public function patchAction(Request $request, Curtain $curtain, Schedule $schedule)
    {
        $oldSchedule = clone $schedule;

        $schedule = $this->updateSchedule($schedule, $request);

        return new JsonResponse(
            ['schedule' => $schedule, 'oldSchedule' => $oldSchedule],
            JsonResponse::HTTP_OK);
    }

    public function deleteAction(Request $request, Curtain $curtain, Schedule $schedule)
    {
        $oldSchedule = clone $schedule;
        $days = $schedule->getWeekdays();

        foreach ($days as $day){
            $day->delete();
        }

        return new JsonResponse(
            ['deletedSchedule' => $oldSchedule],
            JsonResponse::HTTP_OK);
    }

    private function createSchedule(Curtain $curtain, Request $request)
    {
        $schedule = new Schedule();

        $schedule->title = $request->input('title');
        if ($request->input('image'))
            $schedule->image = $request->input('image');
        $schedule->save();

        for ($i = 1; $i < 8; $i++) {
            $day = new Weekday();
            $day->schedule_id = $schedule->id;
            $day->weekday = $i;
            $day->save();
        }
    }

    private function updateSchedule(Schedule $schedule, Request $request)
    {
        if ($request->input('title'))
            $schedule->title = $request->input('title');
        if ($request->input('image'))
            $schedule->image = $request->input('image');

        $schedule->save();

    }
}
