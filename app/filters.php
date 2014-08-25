<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    Metronome\Utils\set_request_method_cookie($request);
});


App::after(function($request, $response)
{
    Metronome\Utils\set_xhr_redirected_to($request, $response);
    if ($response instanceof Illuminate\Http\RedirectResponse) {
        Metronome\Utils\store_for_turbolinks($request, $response->getTargetUrl());
        Metronome\Utils\abort_xdomain_redirect($request, $response);
    }

    // "Turbolinks.visit('#{location}');"
    // 'ContentType' => 'application/x-javascript'

    // if (App::environment() != 'development') {
    //     if ($response instanceof Illuminate\Http\Response) {
    //         $output = $response->getOriginalContent();
    //         $output = preg_replace('/<!--([^\[|(<!)].*)/', '', $output);
    //         $output = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $output);
    //         $output = preg_replace('/\s{2,}/', '', $output);
    //         $output = preg_replace('/(\r?\n)/', '', $output);
    //         $response->setContent($output);
    //     }
    // }

    // This will filter all `pre`, `textarea` tags, not so good.
    // Maybe has a pretty way.
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
    if (Auth::guest()) return Redirect::guest('login');
});

Route::filter('backendable', function()
{
    if (Auth::guest() or Auth::user()->normalUser()) return Redirect::to('/');
});

Route::filter('auth.turbo', function()
{
    if (Auth::guest())
    {
        if (Request::ajax())
        {
            return Response::turbo(join(url('login'), ['Turbolinks.visit(\'', '\');']));
        }

        return Redirect::to('404.html');
    }
});

Route::filter('auth.basic', function()
{
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
    $token = Request::ajax() ? Request::header('x-csrf-token') : (Input::get('_token') ?: Input::get('authenticity_token'));

    if (Session::token() != $token) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
