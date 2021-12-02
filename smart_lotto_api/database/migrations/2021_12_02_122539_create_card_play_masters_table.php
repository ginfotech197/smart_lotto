<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardPlayMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_play_masters', function (Blueprint $table) {
            $table->id();
            $table->string('barcode_number')->unique();
            $table ->foreignId('card_draw_master_id')->references('id')->on('card_draw_masters')->onDelete('cascade');
            $table ->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('activity_done_by')->default('self');

            $table->tinyInteger('is_claimed')->default(0);
            $table->tinyInteger('is_cancelled')->default(0);
            $table->tinyInteger('is_cancelable')->default(1);
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
        Schema::dropIfExists('card_play_masters');
    }
}
