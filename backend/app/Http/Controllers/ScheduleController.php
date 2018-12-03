<?php

namespace App\Http\Controllers;

use Validator;
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
        if($schedule->curtain_id !== $curtain->id)
        {
            return new JsonResponse(['schedule' => null], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['schedule' => $schedule], JsonResponse::HTTP_OK);
    }

    public function postAction(Request $request, Curtain $curtain)
    {
        $badResponse = $this->validateSchedule($request, true);
        if (isset($badResponse)) {
            return $badResponse;
        }

        $schedule = $this->createSchedule($curtain, $request);

        return new JsonResponse(['schedule' => $schedule], JsonResponse::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param bool $hasCreate
     * @return JsonResponse|null
     */
    private function validateSchedule(Request $request, bool $hasCreate = true)
    {
        if ($hasCreate) {
            $validator = Validator::make($request->all(), [
                'title' => 'bail|required|string|max:190',
                'image' => 'bail|nullable|mimes:jpeg,bmp,png',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'bail|string|max:190',
                'image' => 'bail|nullable|mimes:jpeg,bmp,png',
            ]);
        }

        if ($validator->fails()) {
            return new JsonResponse([], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return null;
    }

    public function putAction(Request $request, Curtain $curtain, Schedule $schedule)
    {
        $badResponse = $this->validateSchedule($request, false);
        if (isset($badResponse)) {
            return $badResponse;
        }

        $oldSchedule = clone $schedule;

        $schedule = $this->updateSchedule($schedule, $request);

        return new JsonResponse(
            ['schedule' => $schedule, 'oldSchedule' => $oldSchedule],
            JsonResponse::HTTP_OK);
    }

    public function patchAction(Request $request, Curtain $curtain, Schedule $schedule)
    {
        $badResponse = $this->validateSchedule($request, false);
        if (isset($badResponse)) {
            return $badResponse;
        }

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

        foreach ($days as $day) {
            $day->delete();
        }

        return new JsonResponse(
            ['deletedSchedule' => $oldSchedule],
            JsonResponse::HTTP_OK);
    }

    private function createSchedule(Curtain $curtain, Request $request): Schedule
    {
        $schedule = new Schedule();

        $schedule->curtain_id = $curtain->id;
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

        return $schedule;
    }

    private function updateSchedule(Schedule $schedule, Request $request): Schedule
    {
        if ($request->input('title'))
            $schedule->title = $request->input('title');
        if ($request->input('image'))
            $schedule->image = $request->input('image');

        $schedule->save();

        return $schedule;
    }
}
