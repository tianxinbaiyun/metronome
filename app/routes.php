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
    Route::post('category/store', 'CategoryController@store');

    Route::resource('category', 'CategoryController', ['only'=>['edit', 'update', 'destroy']]);

    Route::get('users', 'UserController@index');
    Route::get('user/{id}', 'UserController@show');
    Route::get('photos', 'PhotoController@index');

    Route::resource('photo', 'PhotoController', ['only'=>['store', 'show', 'destroy']]);

    Route::get('tags', 'TagController@index');
});

Route::get('forum', ['uses'=>'TopicController@index', 'as'=>'home']);

foreach (['/', 'topic', 'topics', 'popular'] as $action) {
    Route::get($action, 'AliasController@index');
}

Route::get('topic/new', 'TopicController@create');

Route::resource('topic', 'TopicController', ['except'=>['index', 'create']]);

Route::get('category/{id}', 'TopicController@byCategory');
Route::get('newest', 'TopicController@newest');

Route::group(['namespace'=>'User'], function()
{
    Route::post('topic/{id}/like', 'LikeController@store');
    Route::delete('topic/{id}/unlike', 'LikeController@destroy');

    Route::post('topic/{id}/subscribe', 'SubscribeController@store');
    Route::delete('topic/{id}/unsubscribe', 'SubscribeController@destroy');
});

Route::post('topic/{id}', 'ReplyController@store');

$reply_array = ['only'=>['edit', 'update', 'destroy']];

Route::resource('reply', 'ReplyController', $reply_array);

Route::get('search', 'SearchController@index');
Route::post('search', 'SearchController@store');

Route::get('login', 'SessionController@create');
Route::get('session/new', 'AliasController@login');
Route::post('session/store', 'SessionController@store');
Route::delete('logout', 'SessionController@destroy');
Route::delete('session/destroy', 'SessionController@destroy');
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

// each do

$user_array = ['likes', 'topics', 'replies', 'following', 'followers', 'watching', 'photos'];

foreach ($user_array as $action) {
    Route::get('{username}/'.$action, 'UserController@'.$action);
}

Route::get('forgot_password', 'ReminderController@getRemind');
Route::post('password/remind', 'ReminderController@postRemind');
Route::get('password/reset/{token}', 'ReminderController@getReset');
Route::post('password/reset', 'ReminderController@postReset');

Route::get('notification', 'NotificationController@index');

Route::post('follow', 'RelationshipController@store');
Route::delete('unfollow', 'RelationshipController@destroy');
Route::get('relationship', 'RelationshipController@show');

Route::get('{username}', 'UserController@profileShow');

Event::listen('illuminate.query', function($query)
{

});

//==>>

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
