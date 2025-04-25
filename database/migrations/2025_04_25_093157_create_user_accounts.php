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
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_type_id')->constrained('user_types')->onDelete('cascade');
            $table->string('email', 255)->unique();
            $table->string('password', 100);
            $table->date('date_of_birth');
            $table->char('gender', 1);
            $table->char('is_active', 1)->default('Y');
            $table->string('contact_number', 10);
            $table->char('sms_notification_active', 1)->default('N');
            $table->char('email_notification_active', 1)->default('N');
            $table->binary('user_image')->nullable();
            $table->date('registration_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_accounts');
    }
};
