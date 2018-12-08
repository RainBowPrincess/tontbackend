<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('customer_id')->unsigned();
            $table->string('ordernummer', 100);
            $table->boolean('shipped')->default(false);  // ska ändras när skickat.
            // $table->boolean('payed')->default(false);

            
            $table->timestamps();
            
            //$table->foreign('customer_id')->references('id')->on('customers');

            //$table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
