@extends('layout.master')

@section('main')
    <div class="boxify">

    @foreach ($notifications as $notification)
        {{ $notification->content }}
    @endforeach

    </div>
@stop

@section('width', 'w720')
