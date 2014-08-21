@extends('layout.master')

@section('main')
    <div class="boxify">
        <div class="user tab">
            @include('user.profile._tab')
        </div>
        <div class="user profile show">
            <p>
                {{ Lang::get('locale.username') }}
                {{ $user->username }}
            </p>
            <p>
                {{ Lang::get('locale.nickname') }}
                {{ $user->profile->nickname }}
            </p>
            <p>
                {{ Lang::get('locale.location') }}
                {{ $user->profile->location }}
            </p>
            <p>
                {{ Lang::get('locale.school') }}
                {{ $user->profile->school }}
            </p>
            <p>
                {{ Lang::get('locale.website') }}
                @if ($website_url = $user->profile->website_url)
                    {{ link_to($website_url) }}
                @endif
            </p>
            <p>
                {{ Lang::get('locale.contact_email') }}
                @if ($contact_email = $user->profile->contact_email)
                    {{ HTML::mailto($contact_email) }}
                @endif
            </p>
            <p>
                {{ Lang::get('locale.biography') }}
                {{ $user->profile->biography }}
            </p>
            <p>
                {{ Lang::get('locale.signup_date') }}
                {{ $user->created_at->toFormattedDateString() }}
                {{ Lang::get('locale.user_number', ['number'=>$user->id]) }}
            </p>
        </div>
    </div>
@stop

@section('width', 'w720')
