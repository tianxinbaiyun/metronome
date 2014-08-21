<ul class="tab tab-five" data-number="{{ $number or 0 }}">
    <li>{{ HTML::link(Str::topicsUrl($user), Lang::get('locale.me')) }}</li>
    <li>{{ HTML::link(Str::likesUrl($user), Lang::get('locale.likes')) }}</li>
    <li>{{ HTML::link(Str::repliesUrl($user), Lang::get('locale.replies')) }}</li>
    <li>{{ HTML::link(Str::watchingUrl($user), Lang::get('locale.watching')) }}</li>
    <li>{{ HTML::link(Str::photosUrl($user), Lang::get('locale.photos')) }}</li>
</ul>
