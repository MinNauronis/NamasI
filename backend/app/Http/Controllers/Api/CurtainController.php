<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurtainStoreRequest;
use App\Http\Requests\CurtainUpdateRequest;
use App\Http\Resources\CurtainResource;
use App\Schedule;
use Illuminate\Validation\Rule;
use Validator;
use App\Curtain;
use App\Service\DemoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurtainController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $curtains = $user->curtains;

        return new JsonResponse(CurtainResource::collection($curtains), JsonResponse::HTTP_OK);
    }

    public function show(Curtain $curtain)
    {
        return new JsonResponse(new CurtainResource($curtain), JsonResponse::HTTP_OK);
    }

    public function store(CurtainStoreRequest $request)
    {
        $user = auth()->user();

        $curtain = new Curtain();
        $curtain->owner_id = $user->id;
        $curtain->title = $request['title'];
        $curtain->micro_controller_id = $request['micro_controller_id'];
        $curtain->is_activated = $request['is_activated'];
        $curtain->save();

        return new JsonResponse(new CurtainResource($curtain), JsonResponse::HTTP_CREATED);
    }

    public function update(CurtainUpdateRequest $request, Curtain $curtain)
    {
        $curtain->update($request->all());

        return new JsonResponse(new CurtainResource($curtain), JsonResponse::HTTP_OK);
    }

    public function delete(Curtain $curtain)
    {
        $curtain->delete();

        return new JsonResponse(new CurtainResource($curtain), JsonResponse::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param bool $hasCreate
     * @return JsonResponse|null
     */
    private function validateCurtain(Request $request, bool $hasCreate = true)
    {
        if ($hasCreate) {
            $validator = Validator::make($request->all(), [
                'title' => 'bail|required|string|max:190',
                'microControllerIp' => 'bail|nullable|regex:/^[0-2][0-5][0-5].[0-2][0-5][0-5].[0-2][0-5][0-5].[0-2][0-5][0-5]$/',
                'isClose' => 'bail|boolean',
                'isTurnOn' => 'bail|boolean',
                'mode' => Rule::in(['auto', 'manual']),
                'selectSchedule_id' => 'bail|nullable|numeric',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'bail|string|max:190',
                'microControllerIp' => 'bail|nullable|regex:/^[0-2][0-5][0-5].[0-2][0-5][0-5].[0-2][0-5][0-5].[0-2][0-5][0-5]$/',
                'isClose' => 'bail|boolean',
                'isTurnOn' => 'bail|boolean',
                'mode' => Rule::in(['off', 'auto', 'manual']),
                'selectSchedule_id' => 'bail|nullable|numeric',
            ]);
        }

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return null;
    }

    private function setCurtain(Curtain $curtain, Request $request, bool $hasCreate = true): Curtain
    {
        if ($request->input('title'))
            $curtain->title = $request->input('title');
        if ($request->input('microControllerIp'))
            $curtain->microControllerIp = $request->input('microControllerIp');
        if ($request->input('isClose'))
            $curtain->isClose = $request->input('isClose');
        if ($request->input('isTurnOn'))
            $curtain->isTurnOn = $request->input('isTurnOn');
        if ($request->input('mode'))
            $curtain->mode = $request->input('mode');
        $scheduleId = $request->input('selectSchedule_id');
        //should be always false on creation
        if (!$hasCreate && is_numeric($scheduleId)) {
            $schedule = Schedule::find($scheduleId);
            if ($schedule->curtain_id === $curtain->id) {
                $curtain->selectSchedule_id = $request->input('selectSchedule_id');
            }
        }

        if ($scheduleId === null) {
            $curtain->selectSchedule_id = null;
        }


        return $curtain;
    }
}
