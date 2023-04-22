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
        Schema::create('question_bank_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('score')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('question_bank_record_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('question_bank_record_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('question_bank_record_id')->references('id')->on('question_bank_records')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('question_bank_record_items', function (Blueprint $table) {
            $table->unsignedBigInteger('question_bank_record_id');
            $table->unsignedBigInteger('question_bank_id');

            $table->foreign('question_bank_record_id')->references('id')->on('question_bank_records')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('question_bank_id')->references('id')->on('question_banks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_bank_records');
    }
};
