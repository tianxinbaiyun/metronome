<?php

class TestingSeeder extends Seeder {

    public function run()
    {
        User::truncate();
        Profile::truncate();
        Category::truncate();
        Topic::truncate();
        Reply::truncate();
        Text::truncate();
        Stat::truncate();

        $category = Category::create([
            'name' => 'Default Category',
            'slug' => 'default-category'
        ]);

        $user = User::create([
            'email'      => 'me@ayur.io',
            'username'   => 'Ayur',
            'downcase'   => 'ayur',
            'avatar_url' => '',
            'password'   => Hash::make('user_password')
        ]);

        $user->profile()->save(new Profile);

        $user->stat()->save(new Stat([
            'verification_token' => Str::random(64)
        ]));

        $user->topics()->save(new Topic([
            'category_id' => 1,
            'title'       => 'My First Topic'
        ]));

        $topic = Topic::first();

        $topic->text()->save(new Text([
            'markup'   => '> markup',
            'markdown' => 'markdown?'
        ]));

        $topic->replies()->save(new Reply([
            'user_id'  => 1,
            'topic_id' => 1,
            'content'  => ''
        ]));

        $reply = Reply::first();

        $reply->text()->save(new Text([
            'markup'   => '> markup',
            'markdown' => 'markdown?'
        ]));
    }
}
