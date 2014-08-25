<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribablesTable extends Migration {

    public function up()
    {
        Schema::create('subscribables', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('subscriber_id')->index();
            $table->integer('subscribable_id')->index();
            $table->integer('subscribable_type')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscribables');
    }
}
