@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="user tab">
            @include('user.profile._tab', ['number'=>3])
        </div>
        <div class="followers">
            @foreach ($user->followers as $follower)
                <div class="user-item">
                    <div class="avatar">
                        <a href="{{ URL::to('user/'.$follower->username) }}">{{ HTML::image($follower->avatar_url) }}</a>
                    </div>
                    <div class="user-info">{{ $follower->username }}</div>
                </div>
            @endforeach
        </div>
    </div>
@stop

@section('width', 'w720')
