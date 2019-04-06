<?php

namespace App\Http\Controllers\Api;

use App\Curtain;
use App\Http\Controllers\Controller;
use App\Http\Requests\LedsUpdateRequest;
use App\Http\Resources\LedsResource;
use Illuminate\Http\JsonResponse;

class LEDSController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Curtain $curtain
     * @return JsonResponse
     */
    public function show(Curtain $curtain)
    {
        return new JsonResponse(new LedsResource($curtain->leds), JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LedsUpdateRequest $request
     * @param Curtain $curtain
     * @return JsonResponse
     */
    public function update(LedsUpdateRequest $request, Curtain $curtain)
    {
        $leds = $curtain->leds();
        $leds->update($request->all());

        return new JsonResponse(new LedsResource($leds), JsonResponse::HTTP_OK);
    }
}
