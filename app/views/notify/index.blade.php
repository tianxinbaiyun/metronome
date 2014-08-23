@extends('layout.master')

@section('main')
    <div class="boxify">
        <ul class="notification index">
            @foreach ($notifications as $notification)
                <li>{{ $notification->content }}<span class="timeago pull_right" title="{{ $notification->created_at }}"></span></li>
            @endforeach
        </ul>
    </div>
@stop

@section('width', 'w720')
