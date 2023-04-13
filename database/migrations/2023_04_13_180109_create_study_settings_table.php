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
        Schema::create('study_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('blur_pathophysiology')->default(false);
            $table->boolean('blur_epidemiology')->default(false);
            $table->boolean('blur_signs')->default(false);
            $table->boolean('blur_diagnosis')->default(false);
            $table->boolean('blur_treatments')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_settings');
    }
};
