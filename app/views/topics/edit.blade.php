@extends('layouts.master')

@section('main')
    <div class="boxify">
        <div class="edit topic">
            {{ Form::open(['url'=>'topic/'.$topic->id, 'method'=>'put']) }}
                {{ Form::label('title', Lang::get('locale.title')) }}
                {{ Form::text('title', $topic->title) }}
                {{ Form::label('body', Lang::get('locale.body')) }}
                {{ Form::textarea('body', $topic->body, ['cols'=>28]) }}
                {{ Form::hidden('category_id', 1) }}
                {{ Form::submit(Lang::get('locale.new_topic'), ['class'=>'btn normal']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('sidebar')
    <div class="boxify">
        <ul class="tab right">
            @foreach ($categories as $category)
                <li><a href="">{{ $category->name }}<span class="pull_right">{{ $category->topics_count }}</span></a></li>
            @endforeach
        </ul>
    </div>
@stop