<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function createUser(Request $request)
    {
        $badResponse = $this->validateSchedule($request, true);
        if (isset($badResponse)) {
            return $badResponse;
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return new JsonResponse(['user' => $user], JsonResponse::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse|null
     */
    private function validateSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:190',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return null;
    }

    public function logout(Request $request)
    {
        $user = $request->user()->token()->revoke();

        return new JsonResponse(["user" => $user], JsonResponse::HTTP_OK);
    }

}