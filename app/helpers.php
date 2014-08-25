<?php

HTML::macro('replyEvent', function(Topic $topic)
{
    return join(' ', [trans('locale.reply'), link_to('topic/'.$topic->id, $topic->title)]);
});

HTML::macro('newTopicEvent', function(Topic $topic)
{
    return join(' ', [trans('locale.new_topic'), link_to('topic/'.$topic->id, $topic->title)]);
});

Str::macro('avatarUrl', function($email = null)
{
    return $email ? URL::to(join('/', ['avatars', join('', [md5($email), 's512.jpg'])])) : '/assets/avatar.jpg';
});

Str::macro('gravatarUrl', function($email = null, $size = null)
{
    // md5(strtolower(trim()))
    return join('', ['http://www.gravatar.com/avatar/', md5($email), '?s=', $size ?: 92, '&d=', urlencode(Config::get('website.avatar_url')), '&r=pg']);
});

Str::macro('calculateScore', function($count, $hour_age, $gravity = 1.8)
{
    return ($count - 1) / pow(($hour_age + 2), $gravity);
});

Str::macro('matching', function($matcher)
{
    return join($matcher, ['%', '%']);
});

/**
 * Turbolinks Helpers
 */

Response::macro('turbo', function($script)
{
    return Response::make($script, 200)->header('Content-Type', 'application/javascript');
});

/**
 * Html Helpers
 */

HTML::macro('username', function($user)
{
    return link_to($user->downcase, $user->username);
});

HTML::macro('topic', function($topic)
{
    return link_to(join('/', ['topic', $topic->id]), $topic->title);
});

/**
 * User Url Helpers
 */

Str::macro('usernameUrl', function($user)
{
    return url($user->username);
});

Str::macro('followingUrl', function($user)
{
    return url(join('/', [$user->username, 'following']));
});

Str::macro('followersUrl', function($user)
{
    return url(join('/', [$user->username, 'followers']));
});

Str::macro('activityUrl', function($user)
{
    return url(join('?tab=', [$user->username, 'activity']));
});

Str::macro('topicUrl', function($user)
{
    return url(join('?tab=', [$user->username, 'topic']));
});

Str::macro('repliesUrl', function($user)
{
    return url(join('/', [$user->username, 'replies']));
});

Str::macro('likesUrl', function($user)
{
    return url(join('/', [$user->username, 'likes']));
});

Str::macro('topicsUrl', function($user)
{
    return url(join('/', [$user->username, 'topics']));
});

Str::macro('watchingUrl', function($user)
{
    return url(join('/', [$user->username, 'watching']));
});

Str::macro('photosUrl', function($user)
{
    return url(join('/', [$user->username, 'photos']));
});

Str::macro('adminUrl', function()
{
    return url('admin');
});

Str::macro('categoriesUrl', function()
{
    return url(join('/', ['admin', 'categories']));
});

Str::macro('tagsUrl', function()
{
    return url(join('/', ['admin', 'tags']));
});

Str::macro('usersUrl', function()
{
    return url(join('/', ['admin', 'users']));
});

Str::macro('backendPhotosUrl', function()
{
    return url(join('/', ['admin', 'photos']));
});
