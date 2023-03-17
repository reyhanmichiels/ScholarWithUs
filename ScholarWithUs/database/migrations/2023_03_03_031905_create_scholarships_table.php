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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_level_id');
            $table->foreignId('tag_cost_id');
            $table->string('name');
            $table->string('scholarship_provider');
            $table->string('description');
            $table->string('university');
            $table->string('study_program');
            $table->string('benefit');
            $table->integer('age');
            $table->float('gpa', 3,2);
            $table->string('english_test');
            $table->string('other_language_test')->default('Not Required');
            $table->string('standarized_test')->default('Not Required');
            $table->string('documents');
            $table->string('other')->nullable();
            $table->string('detail_information');
            $table->string('image');
            $table->date('open_registration');
            $table->date('close_registration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
