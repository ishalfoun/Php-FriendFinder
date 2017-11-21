<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseslotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courseslot', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('coursesection_id')->unsigned();
            $table->foreign('coursesection_id')
                ->references('id')->on('coursesection');

            $table->integer('slot_id')->unsigned();
            $table->foreign('slot_id')
                ->references('id')->on('slot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courseslot');
    }
}
