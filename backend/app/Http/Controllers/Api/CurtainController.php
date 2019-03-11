<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurtainStoreRequest;
use App\Http\Requests\CurtainUpdateRequest;
use App\Http\Resources\CurtainResource;
use App\Curtain;
use Illuminate\Http\JsonResponse;

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
}
