<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardResultMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_result_masters', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('card_draw_master_id')->references('id')->on('card_draw_masters')->onDelete('cascade');
//            $table->foreignId('card_combination_id')->references('id')->on('card_combinations')->onDelete('cascade');

            $table->date('game_date');

            $table->tinyInteger('inforce')->default(1);
            $table->timestamps();
            $table->unique(['card_draw_master_id', 'game_date']);

//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_result_masters');
    }
}
