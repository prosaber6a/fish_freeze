<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChalanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chalan_items', function (Blueprint $table) {
            $table->id();
            $table->integer('chalan_id');
            $table->integer('product_id');
            $table->float('quantity', 10, 2);
            $table->float('rate', 10, 2);
            $table->float('sub_total', 10, 2);
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
        Schema::dropIfExists('chalan_items');
    }
}
