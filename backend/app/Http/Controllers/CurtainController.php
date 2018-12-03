<?php

namespace App\Http\Controllers;

use App\Curtain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurtainController extends Controller
{
    public function getAllAction(Request $request)
    {
        return response()->json('labas', JsonResponse::HTTP_OK);
    }

    public function getAction(Request $request, Curtain $curtain)
    {
        return response()->json(['curtain' => $curtain], JsonResponse::HTTP_OK);
    }

}
