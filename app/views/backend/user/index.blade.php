@extends('layout.backend')

@section('main')
    <div class="boxify">
        <div class="tab user">
            @include('backend._tab', ['number'=>3])
        </div>
        <div class="user index">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>{{ Lang::get('locale.username') }}</th>
                        <th>{{ Lang::get('locale.email') }}</th>
                        <th>{{ Lang::get('locale.verified') }}</th>
                        <th>{{ Lang::get('locale.logged_count') }}</th>
                        <th>{{ Lang::get('locale.logged_ip') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><!-- <a href="{{ URL::to('admin/user/'.$user->id) }}" class="avatar s42">{{ HTML::image($user->avatar_url) }}</a> --></td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->verified }}</td>
                            <td>{{ $user->stat->logged_count }}</td>
                            <td>{{ $user->stat->logged_ip }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('width', 'w720')
