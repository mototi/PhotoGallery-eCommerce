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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id'); // foreign key
            $table->string('name', 100)->nullable(false);
            $table->longText('description') ->nullable();
            $table->decimal('price') ->nullable(false);
            $table->string('image') ->nullable(false);
            $table->string('category') ->nullable();
            $table->integer('stock') ->nullable(false);
            $table->timestamps();

            $table->foreign('admin_id')
            ->references('id')
            ->on('admins')
            ->onDelete('cascade'); // if admin is deleted, delete the product too
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
