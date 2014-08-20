@extends('layout.master')

@section('main')
    <div class="boxify">
        @include('partial.flash')
        <div class="topic show">
            <div class="title">
                <a href="{{ URL::to($reply->topic->user->username) }}" class="avatar s42">{{ HTML::image($reply->topic->user->avatar_url) }}</a>
                <span>{{ $reply->topic->title }}</span>
            </div>
        </div>
        <div class="reply edit">
            {{ Form::open(['url'=>'reply/'.$reply->id, 'method'=>'put']) }}
                {{ Form::label('body', Lang::get('locale.body')) }}
                <textarea name="content">{{ $reply->content }}</textarea>
                {{ Form::submit(Lang::get('locale.save'), ['class'=>'btn normal']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('width', 'w720')
