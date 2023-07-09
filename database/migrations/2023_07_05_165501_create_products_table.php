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
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->string('SKU', 35)->unique();
            $table->float('price')->unsigned()->startingValue(1);
            $table->tinyInteger('discount')->unsigned()->nullable();
            $table->integer('quantity')->unsigned()->default(0);
            $table->string('thumbnail');
            $table->timestamps();
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
