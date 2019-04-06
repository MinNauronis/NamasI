<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeekdayUpdateRequest;
use App\Http\Resources\WeekdayResource;
use App\Schedule;
use App\Weekday;
use Illuminate\Http\JsonResponse;

class WeekdayController extends Controller
{
    public function index(Schedule $schedule)
    {
        $weekdays = $schedule->weekdays;

        return new JsonResponse(WeekdayResource::collection($weekdays), JsonResponse::HTTP_OK);
    }

    public function show(Schedule $schedule, Weekday $weekday)
    {
        if ($weekday->schedule_id !== $schedule->id) {
            return new JsonResponse(new WeekdayResource($weekday), JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(new WeekdayResource($weekday), JsonResponse::HTTP_OK);
    }

    public function update(WeekdayUpdateRequest $request, Schedule $schedule, Weekday $weekday)
    {
        if ($weekday->schedule_id !== $schedule->id) {
            return new JsonResponse(new WeekdayResource($weekday), JsonResponse::HTTP_NOT_FOUND);
        }

        $weekday->update($request->all());

        return new JsonResponse(new WeekdayResource($weekday), JsonResponse::HTTP_OK);
    }
}
