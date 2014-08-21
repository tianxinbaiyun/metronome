@extends('layout.backend')

@section('main')
    <div class="boxify">
        <div class="topic tab">
            @include('backend._tab')
        </div>
        <div class="topic index admin">
            @foreach ($topics as $topic)
                <li>
                    <a href="{{ URL::to('admin/topic/'.$topic->id) }}" data-method="delete"><span class="icon-cross"></span></a>
                    <a href="{{ URL::to('admin/topic/'.$topic->id.'/edit') }}" data-user="{{ $topic->user->username }}" class="title">{{ $topic->title }}<span class="date">{{ $topic->createdAt() }}</span></a>
                </li>
            @endforeach
        </div>
    </div>
@stop

@section('width', 'w720')
