<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePledgeReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pledge_receive', function (Blueprint $table) {
            $table->integer('pledge_id')->unsigned()->references('id')->on('pledges');
            $table->integer('receive_id')->unsigned()->references('id')->on('receives');
            $table->decimal('amount',15,2);            
            $table->enum('status', ['Awaiting payment', 'Awaiting confirmation', 'Confirmed', 'Declined']);
            $table->string('proof_image_path');
            //$table->primary('pledge_id', 'receive_id');
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
        Schema::dropIfExists('pledge_receive');
    }
}
