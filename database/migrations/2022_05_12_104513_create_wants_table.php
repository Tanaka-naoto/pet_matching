<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wants', function (Blueprint $table) {
            $table->id();
            $table->text('can_keep_reson')->comment('飼える根拠');
            $table->text('keep_after')->comment('飼った後');
            $table->unsignedBigInteger('user_id')->comment('飼いたい人');
            $table->unsignedBigInteger('pet_id');
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
        Schema::dropIfExists('wants');
    }
}
