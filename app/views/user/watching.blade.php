@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="user tab">
            @include('user._tab', ['number'=>3])
        </div>
    </div>
@stop

@section('width', 'w720')
