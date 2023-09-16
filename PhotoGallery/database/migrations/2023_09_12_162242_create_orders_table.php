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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // foreign key
            $table->integer('number')->uniqid();
            $table->enum("status" , ["on it" , "shipped" , "delieverd" , "canceled"]);
            $table->integer('total_price');
            $table->date('date')->nullable(false);
            $table->timestamps();


            $table->foreign('customer_id')
            ->references('id')
            ->on('customers')
            ->onDelete('cascade'); // customer is deleted, delete the order too
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
