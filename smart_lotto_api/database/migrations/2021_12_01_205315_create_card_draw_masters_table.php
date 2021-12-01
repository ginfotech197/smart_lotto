<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardDrawMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_draw_masters', function (Blueprint $table) {
            $table->id();

            $table->string('card_draw_name',100)->nullable(true);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('time_diff');
            $table->string('visible_time',20)->nullable(true);
            $table->tinyInteger('active')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_draw_masters');
    }
}
