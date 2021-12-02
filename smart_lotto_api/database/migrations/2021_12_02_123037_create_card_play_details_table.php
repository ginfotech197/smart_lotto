<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardPlayDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_play_details', function (Blueprint $table) {
            $table->id();
            $table ->foreignId('card_play_master_id')->references('id')->on('card_play_masters')->onDelete('cascade');
            $table ->foreignId('game_type_id')->references('id')->on('game_types')->onDelete('cascade');
            $table ->foreignId('card_combination_id')->references('id')->on('card_combinations')->onDelete('cascade');
            $table->integer('quantity')->nullable(false);
            $table->decimal('mrp',10,4)->default(0);
            $table->decimal('commission',10,2)->default(0);
            $table->decimal('payout',10,2)->default(0);
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
        Schema::dropIfExists('card_play_details');
    }
}
