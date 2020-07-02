<?php

namespace Joesama\Profile\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Joesama\Profile\Services\UserProfile;
use Joesama\Profile\Services\ResetPassword;
use Joesama\Profile\Services\ForgotPassword;

class ResetPasswordController extends Controller
{
    const ACTION = 'reset';

    /**
     * Forgot password page.
     *
     * @param Request $request
     *
     * @return view
     */
    public function index($identity, Request $request)
    {
        $profile = (new UserProfile($identity))->info();
        
        return View::make(
            'profile::reset',
            [
                'name' => $profile->name,
                'uri' => URL::temporarySignedRoute(
                    'profile.reset',
                    now()->addMinutes(60),
                    ['key' => $profile->user_id]
                ),
                'type' => self::ACTION,
                'identity' => $identity
            ]
        );
    }

    /**
     * Reset profile password
     *
     * @param String $key
     * @param Request $request
     *
     * @return void
     */
    public function reset($key, Request $request)
    {
        $request->validate(
            [
                'key' => 'required',
                'password' => 'required',
                'repassword' => 'required|same:password'
            ],
            [
                'key.required' => __('profile::verification.validation.key'),
                'repassword.required' => __('profile::verification.validation.repassword'),
                'repassword.same' => __('profile::verification.validation.repassword'),
            ]
        );

        $profile = new ResetPassword($key);

        if ($profile->verify($request->input()) !== true) {
            return Redirect::back()->withErrors($profile->validationErrors())->withInput();
        }

        $model = $profile->resetProfilePassword($request->input());

        return View::make(
            'profile::verified',
            [
                'name' => $model->name,
                'type' => self::ACTION
            ]
        );
    }
}
