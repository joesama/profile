<?php

namespace Joesama\Profile\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Joesama\Profile\Services\UserProfile;
use Joesama\Profile\Services\VerifyProfile;

class ProfileVerificationController extends Controller
{
    const ACTION = 'verification';
    
    public function index($identity, Request $request)
    {
        $profile = (new UserProfile($identity))->info();

        return View::make('profile::verification', [
            'name' => $profile->name,
            'identity' => $identity,
            'type' => self::ACTION
            ]
        );
    }

    public function verified(Request $request)
    {
        $request->validate(
            [
                'key' => 'required',
                'username' => 'required:unique:users',
                'password' => 'required',
                'repassword' => 'required|same:password'
            ],
            [
                'key.required' => __('profile::verification.validation.key'),
                'repassword.required' => __('profile::verification.validation.repassword'),
                'repassword.same' => __('profile::verification.validation.repassword'),
            ]
        );

        $profile = new VerifyProfile($request->get('identity'));

        if ($profile->verify($request->input()) !== true) {
            return Redirect::back()->withErrors($profile->validationErrors())->withInput();
        }

        $model = $profile->verifyingProfile($request->input());

        return View::make('profile::verified', [
                'name' => $model->name,
                'type' => self::ACTION
            ]
        );
    }
}
