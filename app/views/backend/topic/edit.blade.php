@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="topic tab">
            @include('backend._tab')
        </div>
        @include('partial.flash')
        <div class="topic edit">
            {{ Form::open(['url'=>'admin/topic/'.$topic->id, 'method'=>'put']) }}
                {{ Form::label('title', Lang::get('locale.title')) }}
                {{ Form::text('title', $topic->title) }}
                {{ Form::label('body', Lang::get('locale.body')) }}
                {{ Form::textarea('body', $topic->body) }}
                {{ Form::hidden('category_id', $topic->category->id) }}
                {{ Form::submit(Lang::get('locale.save'), ['class'=>'btn normal']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('width', 'w720')
