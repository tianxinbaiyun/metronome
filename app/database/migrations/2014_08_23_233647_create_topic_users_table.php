<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicUsersTable extends Migration {

    public function up()
    {
        Schema::create('topic_users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('topic_id')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('topic_users');
    }
}
