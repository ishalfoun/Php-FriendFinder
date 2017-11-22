<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSlotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_slot', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')
                ->references('id')->on('courses');
            $table->integer('slot_id')->unsigned();
            $table->foreign('slot_id')
                ->references('id')->on('slots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_slot');
    }
}
