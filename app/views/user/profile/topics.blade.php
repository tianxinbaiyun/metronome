@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="user tab">
            @include('user.profile._tab', ['number'=>2])
        </div>
        <ul class="list topic index">
            @foreach ($user->topics as $topic)
                <li>
                    <a class="avatar s42">{{ HTML::image($user->avatar_url) }}</a>
                    <a class="title" href="{{ URL::to('topic/'.$topic->id) }}">{{ $topic->title }}<span class="date timeago" title="{{ $topic->created_at }}">{{ $topic->created_at->diffForHumans() }}</span></a>
                </li>
            @endforeach
        </ul>
        <div class="pagination"></div>
    </div>
@stop

@section('width', 'w720')
