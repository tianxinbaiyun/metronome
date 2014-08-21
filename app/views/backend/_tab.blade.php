<ul class="tab tab-five" data-number="{{ $number or 0 }}">
    <li>{{ HTML::link(Str::adminUrl(), Lang::get('locale.topics')) }}</li>
    <li>{{ HTML::link(Str::categoriesUrl(), Lang::get('locale.categories')) }}</li>
    <li>{{ HTML::link(Str::tagsUrl(), Lang::get('locale.tags')) }}</li>
    <li>{{ HTML::link(Str::usersUrl(), Lang::get('locale.users')) }}</li>
    <li>{{ HTML::link(Str::backendPhotosUrl(), Lang::get('locale.photos')) }}</li>
</ul>
