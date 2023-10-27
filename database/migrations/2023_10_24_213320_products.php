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
        $table->string('name');
        $table->longText('description');
        $table->string('category');
        $table->longText('link');
        $table->float('amount', 8, 2);
        $table->string('image')->nullable()-> default();

        $table->unsignedBigInteger('category_id');
        $table->foreign('category_id')->references('id')->on('categories');

        $table->timestamps();
    });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
