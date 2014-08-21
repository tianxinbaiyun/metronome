@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="user tab">
            @include('user.profile._tab', ['number'=>4])
        </div>
        <div class="following">
            @foreach ($user->following as $followed)
                <div class="user-item">
                    <div class="avatar">
                        <a href="{{ URL::to('user/'.$followed->username) }}">{{ HTML::image($followed->avatar_url) }}</a>
                    </div>
                    <div class="user-info">{{ $followed->username }}</div>
                </div>
            @endforeach
        </div>
    </div>
@stop

@section('width', 'w720')
