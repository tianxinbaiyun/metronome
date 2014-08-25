@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="topic show">
            <div class="title">
                <a href="{{ URL::to($topic->user->username) }}" class="avatar s42">{{ HTML::image($topic->user->avatar_url) }}</a>
                <span>{{{ $topic->title }}}</span>
            </div>
            <div class="body markdown">{{ $topic->body }}</div>
            <div class="topic-opt">
                @if ($liker_right)
                    <a href="{{ URL::to('topic/'.$topic->id.'/unlike') }}" data-method="delete" data-remote="true" class="heart"><span class="icon-heart"></span></a>
                @else
                    <a href="{{ URL::to('topic/'.$topic->id.'/like') }}" data-method="post" data-remote="true"><span class="icon-heart"></span></a>
                @endif

                @if ($watcher_right = 1)
                    <a href="{{ URL::to('topic/'.$topic->id.'/unsubscribe') }}" data-method="delete" data-remote="true" class="pull_right"><span class="icon-check"></span></a>
                @else
                    <a href="{{ URL::to('topic/'.$topic->id.'/subscribe') }}" data-method="post" data-remote="true" class="pull_right checked"><span class="icon-check"></span></a>
                @endif
            </div>
        </div>
    </div>
    @if ($replies->count())
        @include('partial.reply')
    @endif
    <div class="boxify">
        @include('partial.flash')
        <div class="reply new">
            {{ Form::open(['url'=>'topic/'.$topic->id]) }}
                <textarea name="content" placeholder="{{ Lang::get('locale.write_comment') }}"></textarea>
                {{ Form::submit(Lang::get('locale.comment'), ['class'=>'btn normal']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('width', 'w720')
