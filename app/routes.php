<?php

Route::pattern('id', '[0-9]+');
Route::pattern('username', '[A-Z0-9a-z-_]+');
Route::pattern('not_found', '404(\.html)?');

Route::group([
    'domain'    => Config::get('website.api_url'),
    'prefix'    => Config::get('website.api_version'),
    'namespace' => 'Metronome\APIs'
], function()
{
    Route::get('users', 'UserController@index');
    Route::get('topics', 'TopicController@index');
    Route::get('topic/{id}', 'TopicController@show');
    Route::get('{username}', 'UserController@show');
});

Route::group(['prefix'=>'admin', 'namespace'=>'Metronome\Layers'], function()
{
    Route::get('/', 'TopicController@index');

    Route::resource('topic', 'TopicController', ['only'=>['edit', 'update', 'destroy']]);

    Route::get('categories', 'CategoryController@index');
    Route::resource('category', 'CategoryController', ['only'=>['store', 'edit', 'update', 'destroy']]);

    Route::resource('tag', 'TagController', ['only'=>['store', 'edit', 'destroy']]);

    Route::get('users', 'UserController@index');
    Route::get('user/{id}', 'UserController@show');
    Route::get('photos', 'PhotoController@index');

    Route::resource('photo', 'PhotoController', ['only'=>['store', 'show', 'destroy']]);

    Route::get('tags', 'TagController@index');
});


/**
 * Frontend Routes
 */

Route::get('forum', ['uses'=>'TopicController@index', 'as'=>'home']);
Route::get('topic/new', ['uses'=>'TopicController@create', 'as'=>'topic.new']);
Route::resource('topic', 'TopicController', ['except'=>['index', 'create']]);

foreach (['/', 'topic', 'topics', 'popular'] as $action)
{
    Route::get($action, 'AliasController@index');
}

Route::get('newest', 'TopicController@newest');
Route::get('category/{id}', 'TopicController@byCategory');

Route::get('search', 'SearchController@index');

Route::post('topic/{id}', ['uses'=>'ReplyController@store', 'as'=>'reply.store']);
Route::resource('reply', 'ReplyController', ['only'=>['edit', 'update', 'destroy']]);

Route::group(['namespace'=>'User'], function()
{
    Route::post('topic/{id}/like', 'LikeController@store');
    Route::delete('topic/{id}/unlike', 'LikeController@destroy');

    Route::post('topic/{id}/subscribe', 'SubscribeController@store');
    Route::delete('topic/{id}/unsubscribe', 'SubscribeController@destroy');
});

Route::get('login', 'SessionController@create');
Route::get('session/new', 'AliasController@login');

Route::delete('logout', 'SessionController@destroy');
Route::resource('session', 'SessionController', ['only'=>['store', 'destroy']]);
Route::get('logout', 'SessionController@logout');

Route::get('signup', 'UserController@create');
Route::get('user/new', 'AliasController@signup');
Route::get('user', 'AliasController@users');
Route::get('users', 'UserController@index');
Route::post('user/store', 'UserController@store');
Route::get('user/verify/{token}', 'UserController@verify');

Route::get('settings', 'AliasController@profile');
Route::get('settings/profile', 'UserController@profileEdit');
Route::put('settings/profile', 'UserController@profileUpdate');
Route::patch('settings/avatar', 'UserController@avatarUpdate');
Route::get('settings/password', 'UserController@edit');
Route::patch('settings/password', 'UserController@update');

foreach (['likes', 'topics', 'replies', 'following', 'followers', 'watching', 'photos'] as $method) {
    Route::get(join('/', ['{username}', $method]), join('@', ['UserController', $method]));
}

Route::get('forgot_password', 'ReminderController@getRemind');
Route::post('password/remind', 'ReminderController@postRemind');
Route::get('password/reset/{token}', 'ReminderController@getReset');
Route::post('password/reset', 'ReminderController@postReset');

Route::get('notification', 'NotificationController@index');

Route::resource('notification', 'NotificationController', ['only'=>['destroy']]);

Route::post('follow', 'RelationshipController@store');
Route::delete('unfollow', 'RelationshipController@destroy');
Route::get('relationship', 'RelationshipController@show');

Route::get('{username}', 'UserController@profileShow');

Event::listen('illuminate.query', function($query)
{
    if (App::environment() == 'local')
    {
        Log::info($query);
    }
});

//==>>

Route::get('via/turbo', function()
{
    return Turbo::redirectViaTurbolinksTo('admin');
});

// Route::get('score/{id}', function($id)
// {
//     $topic = Topic::find($id);
//     $hour_age = $topic->updated_at->diffInHours($topic->created_at);
//     return Str::calculateScore(10, $hour_age);
//     return $hour_age;
// });

Route::get('queue/receiver', function()
{
    $user = User::find(1);

    Queue::push(function($job) use ($user)
    {
        Mail::send('email.welcome', $data = [], function($message)
        {
            $message->from('hello@nhn.me', 'menglr');
            $message->to('menglr@live.com');
            $message->subject('Welcome!');
        });

        $job->delete();
    });
});
