<?php namespace Metronome\Utils;

use User;

class At {

    const MENTION_LIMIT = 3;

    protected $content;
    protected $users;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function mentions()
    {
        $users = preg_match_all('/@(\w{3,20})/i', $this->content, $this->users)
            ? array_unique($this->users[1])
            : [];

        $this->users = [];

        foreach ($users as $key => $username)
        {
            if ($key < self::MENTION_LIMIT)
            {
                $user = User::whereDowncase(strtolower($username))->first();

                $user and array_push($this->users, $user);
            }
        }

        return $this->users;
    }

    public function content()
    {
        return preg_replace('/@(\w{3,20})\s/i', '<a href="/$1">@$1</a> ', $this->content);
    }
}
