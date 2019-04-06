<?php

namespace App\Http\Controllers\Api;

use App\Curtain;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Arduino\LDRController as Sensor;
use Illuminate\Http\JsonResponse;

class LDRController extends Controller
{
    private $sensor;

    public function __construct(Sensor $sensor)
    {
        $this->sensor = $sensor;
    }

    /**
     * Display the specified resource.
     *
     * @param Curtain $curtain
     * @return JsonResponse
     */
    public function show(Curtain $curtain)
    {
        $light = $this->sensor->getLightIntensive($curtain);

        $statusCode = empty($light['sun_intensive']) ? JsonResponse::HTTP_SERVICE_UNAVAILABLE : JsonResponse::HTTP_OK;

        return new JsonResponse($light, $statusCode);
    }
}
