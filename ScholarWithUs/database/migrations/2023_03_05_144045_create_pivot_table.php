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
        Schema::create('program_user', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->foreignId('program_id');
        });

        Schema::create('course_program', function (Blueprint $table) {
            $table->foreignId('course_id');
            $table->foreignId('program_id');
        });

        Schema::create('mentor_program', function (Blueprint $table) {
            $table->foreignId('mentor_id');
            $table->foreignId('program_id');
        });

        Schema::create('program_tag_country', function (Blueprint $table) {
            $table->foreignId('tag_country_id');
            $table->foreignId('program_id');
        });

        Schema::create('scholarship_tag_country', function (Blueprint $table) {
            $table->foreignId('tag_country_id');
            $table->foreignId('scholarship_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_user');
        Schema::dropIfExists('course_program');
        Schema::dropIfExists('discussion_tag');
    }
};
