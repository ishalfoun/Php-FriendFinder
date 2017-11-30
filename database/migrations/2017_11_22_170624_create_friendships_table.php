<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('friend1_id')->unsigned();
            $table->foreign('friend1_id')
                ->references('id')->on('users');

            $table->integer('friend2_id')->unsigned();
            $table->foreign('friend2_id')
                ->references('id')->on('users');
            $table->string('status');

            $table->unique(['friend1_id', 'friend2_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friendships');
    }
}
