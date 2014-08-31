@extends('layout.master')

@section('main')
    <div class="boxify">
        @include('partial.flash')
        <div class="session new">
            {{ Form::open(['route'=>'session.store']) }}
                {{ Form::label('account', Lang::get('locale.account')) }}
                {{ Form::text('account') }}
                {{ Form::label('password', Lang::get('locale.password')) }}
                {{ Form::password('password') }}
                <label class="rememberme">
                    {{ Form::checkbox('remember_me') }}
                    <span>{{ Lang::get('locale.remember_me') }}</span>
                </label>
                <span class="pull_right"><a href="{{ URL::to('forgot_password') }}">{{ Lang::get('locale.forgot_password') }}</a></span>
                {{ Form::submit(Lang::get('locale.login'), ['class'=>'btn normal']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('width', 'w420')
