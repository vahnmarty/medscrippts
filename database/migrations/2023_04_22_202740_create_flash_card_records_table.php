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
        Schema::create('flash_card_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('confidence')->nullable();
            $table->integer('reviewed')->nullable();
            $table->timestamps();
        });

        Schema::create('flash_card_record_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('flash_card_record_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('flash_card_record_id')->references('id')->on('flash_card_records')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('flash_card_record_items', function (Blueprint $table) {
            $table->unsignedBigInteger('flash_card_record_id');
            $table->unsignedBigInteger('flash_card_id');

            $table->foreign('flash_card_record_id')->references('id')->on('flash_card_records')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('flash_card_id')->references('id')->on('flash_cards')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_card_record_categories');
        Schema::dropIfExists('flash_card_record_items');
        Schema::dropIfExists('flash_card_records');
    }
};
