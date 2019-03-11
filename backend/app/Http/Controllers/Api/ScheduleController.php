<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Http\Resources\ScheduleResource;
use Validator;
use App\Curtain;
use App\Schedule;
use App\Weekday;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Curtain $curtain)
    {
        $schedules = $curtain->schedules;

        return new JsonResponse(ScheduleResource::collection($schedules), JsonResponse::HTTP_OK);
    }

    public function show(Curtain $curtain, Schedule $schedule)
    {
        if ($schedule->curtain_id !== $curtain->id) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(new ScheduleResource($schedule), JsonResponse::HTTP_OK);
    }

    public function store(ScheduleStoreRequest $request, Curtain $curtain)
    {
        $schedule = new Schedule();
        $schedule->curtain_id = $curtain->id;
        $schedule->owner_id = $curtain->owner->id;
        $schedule->title = $request['title'];
        $schedule->image = 'Please convert it to image, null allowed'; //todo Image::convert($request['image'])  ar pan.
        $schedule->save();

        return new JsonResponse(new ScheduleResource($schedule), JsonResponse::HTTP_CREATED);
    }

    public function update(ScheduleUpdateRequest $request, Curtain $curtain, Schedule $schedule)
    {
        if ($schedule->curtain->id !== $curtain->id) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        if (isset($request['image'])) {
            //todo update image (delete old, insert new)
            $request['image'] = 'New url to image';
        }

        $schedule->update($request->all());

        return new JsonResponse(new ScheduleResource($schedule), JsonResponse::HTTP_OK);
    }

    public function delete(Curtain $curtain, Schedule $schedule)
    {
        if ($schedule->curtain->id !== $curtain->id) {
            return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
        }

        $schedule->delete();

        return new JsonResponse(new ScheduleResource($schedule), JsonResponse::HTTP_OK);
    }
}
