<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Profile Frontend Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web','guest'])
    ->group(function (Router $router) {
        $router->namespace('Joesama\Profile\Http\Controllers')->group(function (Router $router) {
            $router->middleware('signed')->get(
                'profile/verify/{identity}',
                'ProfileVerificationController@index'
            )->name('profile.verify');

            $router->post(
                'profile/verified',
                'ProfileVerificationController@verified'
            )->name('profile.verification');

            $router->get(
                'profile/forgot',
                'ForgotPasswordController@index'
            )->name('profile.forgot');

            $router->middleware('signed')->post(
                'profile/forgot/{key}',
                'ForgotPasswordController@forgot'
            )->name('profile.forgot.request');

            $router->get(
                'profile/password/{identity}',
                'ResetPasswordController@index'
            )->name('profile.password');

            $router->middleware('signed')->post(
                'profile/reset/{key}',
                'ResetPasswordController@reset'
            )->name('profile.reset');
        });
    });
