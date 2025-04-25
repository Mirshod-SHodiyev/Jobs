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
        Schema::create('job_post_skill_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_set_id')->constrained('skill_sets');
            $table->foreignId('job_post_id')->constrained('job_posts');
            $table->integer('experience_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_skill_sets');
    }
};
