<?php

namespace App\Http\Controllers\Api\Auth\Traits;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

trait RegistersUsers
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $token = $this->guard()->login($user);

        return response()->json([
            'message' => trans('auth.register.success'),
            'token' => $token,
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ], Response::HTTP_OK);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
