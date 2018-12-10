<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Validation\Rule;
use Validator;
use App\Curtain;
use App\Service\DemoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurtainController extends Controller
{
    public function getAllAction(Request $request)
    {
        //TODO only for user
        $curtains = Curtain::all();//->where('user_id', 1);
        return new JsonResponse(['curtains' => $curtains], JsonResponse::HTTP_OK);
    }

    public function getAction(Request $request, Curtain $curtain)
    {
        //TODO
        /*if($curtain->user_id() !== user)
        {
            return new JsonResponse(['curtain' => null], JsonResponse::HTTP_NOT_FOUND);
        }*/

        return new JsonResponse(['curtain' => $curtain], JsonResponse::HTTP_OK);
    }

    public function postAction(Request $request)
    {
        $badResponse = $this->validateCurtain($request, true);
        if (isset($badResponse)) {
            return $badResponse;
        }

        $curtain = new Curtain();
        //TODO user....
        //$curtain->user_id = $request->user()->id;
        $curtain->user_id = 1;
        $curtain = $this->setCurtain($curtain, $request, true);
        $curtain->save();

        return new JsonResponse(['curtain' => $curtain], JsonResponse::HTTP_CREATED);
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
                'mode' => Rule::in(['off', 'auto', 'manual']),
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

        if($scheduleId === null) {
            $curtain->selectSchedule_id = null;
        }


        return $curtain;
    }

    public function putAction(Request $request, Curtain $curtain)
    {
        $badResponse = $this->validateCurtain($request, false);
        if (isset($badResponse)) {
            return $badResponse;
        }

        $oldCurtain = clone $curtain;
        $curtain = $this->setCurtain($curtain, $request, false);
        $curtain->save();

        return new JsonResponse(
            ['curtain' => $curtain, 'oldCurtain' => $oldCurtain],
            JsonResponse::HTTP_OK);
    }

    public function patchAction(Request $request, Curtain $curtain)
    {
        $badResponse = $this->validateCurtain($request, false);
        if (isset($badResponse)) {
            return $badResponse;
        }

        $oldCurtain = clone $curtain;
        $curtain = $this->setCurtain($curtain, $request, false);
        $curtain->save();

        return new JsonResponse(
            ['curtain' => $curtain, 'oldCurtain' => $oldCurtain],
            JsonResponse::HTTP_OK);
    }

    public function deleteAction(Request $request, Curtain $curtain)
    {
        $oldCurtain = clone $curtain;
        $schedules = $curtain->getSchedules;
        foreach ($schedules as $schedule ){
            app('App\Http\Controllers\ScheduleController')->delete($schedule);
        }

        $curtain->delete();

        return new JsonResponse(
            ['deletedCurtain' => $oldCurtain],
            JsonResponse::HTTP_OK);
    }
}
