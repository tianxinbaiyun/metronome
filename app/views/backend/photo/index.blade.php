@extends('layout.backend')

@section('main')
    <div class="boxify">
        <div class="photo tab">
            @include('backend._tab', ['number'=>4])
        </div>
        <ul class="photo index">
            @foreach ($photos as $photo)
                <li>
                    <a href="{{ URL::to('admin/photo/'.$photo->id) }}">{{ HTML::image('uploads/'.$photo->hash.'.jpg') }}</a>
                    <a href="{{ URL::to('admin/photo/'.$photo->id) }}" class="" data-method="delete"><span class="icon-cross"></span></a>
                </li>
            @endforeach
            <li>
                <div class="photo new">
                    {{ HTML::image('assets/square.png') }}
                    <div class="uploader square"><span class="icon-upload"></span></div>
                    {{ Form::open(['url'=>URL::to('admin/photo/store'), 'method'=>'post', 'files'=>true]) }}
                        {{ Form::file('photo', ['class'=>'auto']) }}
                    {{ Form::close() }}
                </div>
            </li>
        </ul>
    </div>
@stop

@section('width', 'w720')
