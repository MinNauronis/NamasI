<?php

namespace App\Http\Controllers;

Use Validator;
use App\Schedule;
use App\Weekday;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WeekdayController
{
    public function getAllAction(Request $request, Schedule $schedule)
    {
        $scheduleId = $schedule->id;
        $days = Weekday::where('schedule_id', '=', $scheduleId)->get();

        return new JsonResponse(['days' => $days], JsonResponse::HTTP_OK);
    }

    public function getAction(Request $request, Schedule $schedule, Weekday $weekday)
    {
        if($weekday->schedule_id !== $schedule->id)
        {
            return new JsonResponse(['day' => null], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['day' => $weekday], JsonResponse::HTTP_OK);
    }

    public function putAction(Request $request, Schedule $schedule, Weekday $weekday)
    {
        $oldDay = clone $weekday;

        if ($request->input('mode'))
            $weekday->mode = $request->input('mode');
        if ($request->input('openTime'))
            $weekday->openTime = $request->input('openTime');
        if ($request->input('closeTime'))
            $weekday->closeTime = $request->input('closeTime');
        $weekday->save();

        return new JsonResponse(
            ['day' => $weekday, 'oldDay' => $oldDay],
            JsonResponse::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param bool $hasCreate
     * @return JsonResponse|null
     */
    private function validateWeekday(Request $request, bool $hasCreate = true)
    {
        $validator = Validator::make($request->all(), [
            'mode' =>       Rule::in(['sun', 'time', 'skip']),
            'openTime' =>   'bail|nullable|date_format:"H:i:s"',
            'closeTime' =>  'bail|nullable|date_format:"H:i:s"',
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return null;
    }
}
