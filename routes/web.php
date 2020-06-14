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
        });
    });
