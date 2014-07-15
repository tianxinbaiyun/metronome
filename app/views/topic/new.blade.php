@extends('layout.master')

@section('main')
    <div class="boxify">
        @include('partials.notify')
        <div class="new topic">
            {{ Form::open(['url'=>'topic/store']) }}
                {{ Form::label('title', Lang::get('locale.title')) }}
                {{ Form::text('title') }}
                {{ Form::label('body', Lang::get('locale.body')) }}
                {{ Form::textarea('body', '', ['cols'=>28]) }}
                {{ Form::hidden('category_id', 0, ['id'=>'category']) }}
                {{ Form::submit(Lang::get('locale.new_topic'), ['class'=>'btn normal']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('sidebar')
    <div class="boxify">
        <ul class="tab right select">
            @foreach ($categories as $category)
                <li><a href="#{{ $category->id }}" data-category="{{ $category->id }}">{{ $category->name }}<span class="pull_right">{{ $category->topics_count }}</span></a></li>
            @endforeach
        </ul>
    </div>
@stop