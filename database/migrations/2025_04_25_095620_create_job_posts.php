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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->string('job_title');
            $table->foreignId('job_type_id')->constrained('job_types');
            $table->text('job_description');
            $table->timestamp('creation_date')->useCurrent();
            $table->date('expiry_date');
            $table->string('offered_salary')->nullable();
            $table->string('country_code')->nullable();
            $table->foreignId('job_location_id')->constrained('job_locations');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
