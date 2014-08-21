@extends('layout.backend')

@section('main')
    <div class="boxify">
        <div class="category tab">
            @include('backend._tab', ['number'=>1])
        </div>
        @include('partial.flash')
        <div class="category edit">
            {{ Form::open(['url'=>'admin/category/'.$category->id, 'method'=>'put']) }}
                {{ Form::label('name', Lang::get('locale.name')) }}
                {{ Form::text('name', $category->name) }}
                {{ Form::label('slug', Lang::get('locale.slug')) }}
                {{ Form::text('slug', $category->slug) }}
                {{ Form::submit(Lang::get('locale.save'), ['class'=>'btn primary']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('width', 'w720')
