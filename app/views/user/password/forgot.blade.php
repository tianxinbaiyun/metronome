@extends('layout.master')

@section('main')
    <div class="boxify">
        @include('partial.flash')
        @if (Session::has('error'))
            <div class="message flash">
                <p>{{ Session::get('error') }}</p>
            </div>
        @endif
        <div class="user password forgot">
            {{ Form::open(['url'=>'password/remind']) }}
                {{ Form::label('email', Lang::get('locale.email')) }}
                {{ Form::text('email') }}
                {{ Form::submit(Lang::get('locale.submit'), ['class'=>'btn normal']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('width', 'w560')
