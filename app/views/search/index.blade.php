@extends('layout.master')

@section('main')
    <div class="boxify">
        @include('partial.flash')
        <div class="search index">
            {{ Form::open(['url'=>'search', 'method'=>'get']) }}
                {{ Form::text('q', Input::get('q'), ['placeholder'=>Lang::get('locale.search')]) }}
                {{ Form::submit(Lang::get('locale.search'), ['class'=>'btn normal']) }}
            {{ Form::close() }}
        </div>
        @if (Input::has('q'))
            <ul class="list topic index">
                @foreach ($topics as $topic)
                    <li>
                        <a href="{{ URL::to($topic->user->username) }}" class="avatar s42">{{ HTML::image($topic->user->avatar_url) }}</a>
                        <a href="{{ URL::to('topic/'.$topic->id) }}" class="title">{{ $topic->title }}<span class="date">{{ $topic->created_at->toFormattedDateString() }}</span></a>
                    </li>
                @endforeach
            </ul>
            {{ $topics->links() }}
        @endif
    </div>
@stop

@section('width', 'w720')
