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
        Schema::create('customer_product', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('customer_id');

            $table->integer('quantity')->default(1);
            $table->integer('price')->nullable(false);

            $table->primary(['product_id', 'customer_id']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->OnDelete('strict'); // if product is deleted, transaction is not deleted

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->OnDelete('cascade'); // if customer is deleted, transaction is deleted too
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_customer');
    }
};
