@extends('layout.backend')

@section('main')
    <div class="boxify">
        <div class="tab tag">
            @include('backend._tab', ['number'=>2])
        </div>
        <div class="tag index">

        </div>
        <div class="tag new">
            {{ Form::open(['route'=>'admin.tag.store']) }}
                {{ Form::text('name') }}
                {{ Form::submit(Lang::get('locale.create_tag'), ['class'=>'btn primary']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('width', 'w720')
