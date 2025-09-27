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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->enum('level', ['certificate', 'diploma', 'bachelor', 'master', 'phd']);
            $table->integer('duration_months');
            $table->decimal('tuition_fee', 12, 2);
            $table->string('currency', 3)->default('EUR');
            $table->json('requirements')->nullable();
            $table->json('career_prospects')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('application_deadline')->nullable();
            $table->date('start_date')->nullable();
            $table->string('language_of_instruction')->default('French');
            $table->enum('mode_of_study', ['full-time', 'part-time', 'online'])->default('full-time');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['school_id', 'level']);
            $table->index('is_active');
            $table->index('tuition_fee');
            $table->index('application_deadline');
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
