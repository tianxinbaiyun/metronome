@extends('layout.backend')

@section('main')
    <div class="boxify">
        <div class="tab user">
            @include('backend._tab', ['number'=>3])
        </div>
        <div class="user edit">
        {{ var_dump($user->profile->toArray()) }}
        </div>
    </div>
@stop

@section('width', 'w720')
