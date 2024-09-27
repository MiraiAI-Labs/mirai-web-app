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
        Schema::create('user_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('archetype_id');
            $table->unsignedDouble('cognitive')->default(0);
            $table->unsignedDouble('motivation')->default(0);
            $table->unsignedDouble('adaptability')->default(0);
            $table->unsignedDouble('creativity')->default(0);
            $table->unsignedDouble('eq')->default(0);
            $table->unsignedDouble('interpersonal')->default(0);
            $table->unsignedDouble('technical')->default(0);
            $table->unsignedDouble('scholastic')->default(0);
            $table->unsignedInteger('exp')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('archetype_id')->references('id')->on('archetypes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_statistics');
    }
};
