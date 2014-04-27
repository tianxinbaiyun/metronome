<?php

use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration {

    public function up()
    {
        Schema::create('topics', function($table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->string('title');
            $table->text('body');
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->boolean('trashed')->default(false);
            $table->boolean('frozen')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
