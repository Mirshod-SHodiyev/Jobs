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
        Schema::create('seeker_skill_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_profile_id')->constrained('seeker_profiles');
            $table->foreignId('skill_set_id')->constrained('skill_sets');
            $table->string('skill_level')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeker_skill_sets');
    }
};
