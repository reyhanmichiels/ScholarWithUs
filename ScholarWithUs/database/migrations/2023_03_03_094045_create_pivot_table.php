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

        Schema::create('discussion_tag', function (Blueprint $table) {
            $table->foreignId('discussion_id');
            $table->foreignId('tag_id');
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
