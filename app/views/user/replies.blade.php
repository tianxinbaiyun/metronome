@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="user tab">
            @include('user._tab', ['number'=>2])
        </div>
        <ul class="list topic index">

        </ul>
    </div>
@stop

@section('width', 'w720')
