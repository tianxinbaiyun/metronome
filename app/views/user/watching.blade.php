@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="user tab">
            @include('user._tab', ['number'=>3])
        </div>
        <ul class="list topic index">
            @foreach ($user->watching as $topic)
                <li>
                    <a class="avatar s42">{{ HTML::image($user->avatar_url) }}</a>
                    <a class="title" href="{{ URL::to('topic/'.$topic->id) }}">{{ $topic->title }}<span class="date timeago" title="{{ $topic->created_at }}"></span></a>
                </li>
            @endforeach
        </ul>
    </div>
@stop

@section('width', 'w720')
