<?php

namespace Joesama\Profile\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Joesama\Profile\Services\ForgotPassword;

class ForgotPasswordController extends Controller
{
    const ACTION = 'forgot';

    /**
     * Forgot password page.
     *
     * @param Request $request
     *
     * @return view
     */
    public function index(Request $request)
    {
        $key = Str::uuid();

        $request->session()->put('reset', $key);

        return View::make(
            'profile::forgot',
            [
                'name' => null,
                'uri' => URL::temporarySignedRoute(
                    'profile.forgot.request',
                    now()->addMinutes(60),
                    ['key' => $key]
                ),
                'type' => self::ACTION
            ]
        );
    }

    /**
     * Sent notification for reset password.
     *
     * @param [type] $key
     * @param Request $request
     *
     * @return void
     */
    public function forgot($key, Request $request)
    {
        $profile = (new ForgotPassword($request->get('email')));

        $input = array_merge(
            $request->input(),
            [
                'key' => $key,
                'session-key' => (string) $request->session()->pull('reset')
            ]
        );

        if ($profile->verify($input) !== true) {
            return Redirect::back()->withErrors($profile->validationErrors())->withInput();
        }

        $model = $profile->sentRequestNotification($request->input());

        return View::make(
            'profile::verified',
            [
                'name' => $model->name,
                'type' => self::ACTION
            ]
        );
    }
}
