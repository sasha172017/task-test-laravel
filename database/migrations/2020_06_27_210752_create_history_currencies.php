<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryCurrencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_currencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')
                ->references('id')->on('currencies')
                ->onDelete('cascade')
            ;
            $table->float('buy');
            $table->float('sell');
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
        Schema::dropIfExists('history_currencies');
    }
}
