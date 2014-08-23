<?php namespace Metronome\Repositories;

use DB;
use URL;
use Auth;
use HTML;
use Lang;
use User;
use Topic;
use DateTime;
use Notification;

class NotifierRepository {

    protected $auth_user;
    protected $notified_user;
    protected $notifications = [];

    public function __construct(User $user = null)
    {
        $this->auth_user = $user ?: Auth::user();
    }

    public function notify(User $user, Topic $topic = null)
    {
        $this->notified_user = $user;

        return $this;
    }

    public function watchingReplied(Topic $topic)
    {
        $content = $this->setTemplate(Lang::get('locale.watching_replied', ['topic'=>HTML::topic($topic)]));

        $this->setContent($content);
    }

    public function replied(Topic $topic)
    {
        $content = $this->setTemplate(Lang::get('locale.topic_replied', ['topic'=>HTML::topic($topic)]));

        $this->setContent($content);
    }

    public function watched(Topic $topic)
    {
        $content = $this->setTemplate(Lang::get('locale.topic_watched', ['topic'=>HTML::topic($topic)]));

        $this->setContent($content);
    }

    public function liked(Topic $topic)
    {
        $content = $this->setTemplate(Lang::get('locale.topic_liked', ['topic'=>HTML::topic($topic)]));

        $this->setContent($content);
    }

    public function mentioned(Topic $topic)
    {
        $content = $this->setTemplate(Lang::get('locale.mentioned', ['topic'=>HTML::topic($topic)]));

        $this->setContent($content);
    }

    public function followed()
    {
        $this->setContent($this->setTemplate(Lang::get('locale.followed')));
    }

    public function send()
    {
        DB::table('notifications')->insert($this->notifications);
    }

    private function setTemplate($template)
    {
        return join(' ', [HTML::username($this->auth_user), $template]);
    }

    private function setContent($content)
    {
        array_push($this->notifications, [
            'user_id'    => $this->notified_user->id,
            'content'    => $content,
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);
    }
}
