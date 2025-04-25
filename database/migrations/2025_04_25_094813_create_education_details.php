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
        Schema::create('education_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_profile_id')->constrained('seeker_profiles');
            $table->string('certificate_degree_name');
            $table->string('major')->nullable();
            $table->string('university_name');
            $table->date('starting_date');
            $table->date('completion_date')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('cgpa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_details');
    }
};
