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
        Schema::create('question_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        Schema::create('question_bank_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_bank_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('question_bank_id')->references('id')->on('question_banks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_bank_categories');
        Schema::dropIfExists('question_banks');
    }
};
