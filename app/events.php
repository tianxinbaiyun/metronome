<?php

Event::listen('user.stat', function(User $user, $stat = null)
{
    if ($stat)
    {
        $stat = $user->stat;
    }
    else
    {
        $stat = new Stat;
        $stat->user_id = $user->id;
        $stat->verification_token = Str::random(64);
    }

    $stat->logged_count = $stat->logged_count + 1;

    $stat->last_logged_ip = $stat->logged_ip;
    $stat->last_logged_at = $stat->logged_at;

    $stat->logged_ip = Request::getClientIp();
    $stat->logged_at = new DateTime;

    $stat->save();
});

Event::listen('reply.mention', function(array $mentions)
{

});

App::error(function(Illuminate\Database\Eloquent\ModelNotFoundException $exception)
{
    return ['404.html'];
});

// View::composer(['topics.*', 'users.*'], function($view)
// {
//     $view->with('stat', Stat::orderBy('id', 'desc')->first());
// });
