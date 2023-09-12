<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_order', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('order_id');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->OnDelete('strict'); // if product is deleted, transaction is not deleted

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->OnDelete('cascade'); // if order is deleted, transaction is deleted too
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_order');
    }
};
