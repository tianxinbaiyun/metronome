@extends('layout.backend')

@section('main')
    <div class="boxify">
        <div class="tab tag">
            @include('backend._tab', ['number'=>2])
        </div>
        <div class="tag index">

        </div>
    </div>
@stop

@section('width', 'w720')
