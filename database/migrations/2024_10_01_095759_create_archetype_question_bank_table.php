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
        Schema::create('archetype_question_bank', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('archetype_id');
            $table->text('question');
            $table->timestamps();

            $table->foreign('archetype_id')->references('id')->on('archetypes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archetype_question_bank');
    }
};
