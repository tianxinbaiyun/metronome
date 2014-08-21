<ul class="tab tab-five" data-number="{{ $number or 0 }}">
    <li><a href="{{ Str::usernameUrl($user) }}" class="avatar-sp">{{ HTML::image($user->avatar_url) }}</a></li>
    <li>{{ HTML::link(Str::activityUrl($user), Lang::get('locale.activity')) }}</li>
    <li>{{ HTML::link(Str::topicUrl($user), Lang::get('locale.topic')) }}</li>
    <li>{{ HTML::link(Str::followersUrl($user), Lang::get('locale.followers')) }}</li>
    <li>{{ HTML::link(Str::followingUrl($user), Lang::get('locale.following')) }}</li>
</ul>
