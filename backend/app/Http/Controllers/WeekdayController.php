<?php
/**
 * Created by PhpStorm.
 * User: Mindaugas
 * Date: 2018-12-03
 * Time: 22:20
 */

namespace App\Http\Controllers;


use App\Schedule;
use App\Weekday;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeekdayController
{
    public function getAllAction(Request $request, Schedule $schedule)
    {
        $scheduleId = $schedule->id;
        $days = Weekday::all()->where('schedule_id', $scheduleId);

        return new JsonResponse(['days' => $days], JsonResponse::HTTP_OK);
    }

    public function getAction(Request $request, Schedule $schedule, Weekday $weekday)
    {
        return new JsonResponse(['day' => $weekday], JsonResponse::HTTP_OK);
    }

    public function putAction(Request $request, Schedule $schedule, Weekday $weekday)
    {
        $oldDay = clone $weekday;

        if ($request->input('mode'))
            $weekday->title = $request->input('mode');
        if ($request->input('openTime'))
            $weekday->openTime = $request->input('openTime');
        if ($request->input('closeTime'))
            $weekday->closeTime = $request->input('closeTime');

        return new JsonResponse(
            ['day' => $weekday, 'oldDay' => $oldDay],
            JsonResponse::HTTP_OK);
    }
}
