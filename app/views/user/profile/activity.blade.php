@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="user tab">
            @include('user.profile._tab', ['number'=>1])
        </div>
        <div class="user activity">
            @foreach ($user->events as $activity)
                <p><a href="{{ URL::to($user->username) }}">{{ $user->username }}</a> {{ $activity->content }}<span class="date timeago" title="{{ $activity->created_at }}"></span></p>
            @endforeach
        </div>
    </div>
@stop

@section('width', 'w720')
