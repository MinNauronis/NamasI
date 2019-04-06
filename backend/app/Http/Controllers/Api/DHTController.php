<?php

namespace App\Http\Controllers\Api;

use App\Curtain;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Arduino\DHTController as Sensor;
use Illuminate\Http\JsonResponse;

class DHTController extends Controller
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
        $dht = $this->sensor->getDHT($curtain);

        $statusCode = empty($dht['humidity']) ? JsonResponse::HTTP_SERVICE_UNAVAILABLE : JsonResponse::HTTP_OK;

        return new JsonResponse($dht, $statusCode);
    }
}
