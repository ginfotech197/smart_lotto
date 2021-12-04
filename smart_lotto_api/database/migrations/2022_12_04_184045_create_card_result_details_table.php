<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardResultDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_result_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('card_result_masters_id')->references('id')->on('card_result_masters')->onDelete('cascade');
            $table ->foreignId('game_type_id')->references('id')->on('game_types')->onDelete('cascade');
            $table->foreignId('card_combination_id')->references('id')->on('card_combinations')->onDelete('cascade');

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
        Schema::dropIfExists('card_result_details');
    }
}
