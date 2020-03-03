<?php

namespace App\Http\Controllers\Frontend\Api\Auth;

use App\Events\Frontend\Auth\UserLoggedOut;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LogoutController extends Controller
{
    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        event(new UserLoggedOut($user));

        $user->currentAccessToken()->delete();

        return [];
    }
}
