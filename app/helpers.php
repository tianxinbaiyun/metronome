<?php

HTML::macro('replies', function($user)
{
    return link_to(join('/', [$user->username, 'replies']), trans('locale.reply'));
});

HTML::macro('topics', function($user)
{
    return link_to(join('?', [$user->username, 'tab=topic']), trans('locale.topic'));
});

HTML::macro('authTopics', function($user)
{
    return link_to(join('/', [$user->username, 'topics']), trans('locale.me'));
});

HTML::macro('watching', function($user)
{
    return link_to(join('/', [$user->username, 'watching']), trans('locale.watching'));
});

HTML::macro('likes', function($user)
{
    return link_to(join('/', [$user->username, 'likes']), trans('locale.likes'));
});

HTML::macro('categories', function()
{
    return link_to('admin/categories', trans('locale.category'));
});

HTML::macro('tags', function()
{
    return link_to('admin/tags', trans('locale.tag'));
});

HTML::macro('users', function()
{
    return link_to('admin/users', trans('locale.users'));
});

HTML::macro('admin', function()
{
    return link_to('admin', trans('locale.topic'));
});

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
