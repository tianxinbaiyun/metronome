@extends('layout.master')

@section('main')
    <div class="boxify">
        @include('partial.flash')
        <div class="topic new">
            {{ Form::open(['route'=>'topic.store']) }}
                {{ Form::label('title', Lang::get('locale.title')) }}
                {{ Form::text('title') }}
                {{ Form::label('body', Lang::get('locale.body')) }}
                <textarea name="body"></textarea>
                {{ Form::hidden('category_id', 1, ['id'=>'category']) }}
                {{ Form::submit(Lang::get('locale.create_topic'), ['class'=>'btn normal']) }}
            {{ Form::close() }}
        </div>
    </div>
    <div class="boxify">
        <div class="category selection">
            @foreach ($categories as $category)
                <a href="#category-{{ $category->id }}" data-category-id="{{ $category->id }}">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>
@stop

@section('width', 'w720')
