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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('field_of_study'); // Filière demandée
            $table->string('diploma_level'); // Niveau de diplôme souhaité
            $table->text('motivation_letter'); // Lettre de motivation
            $table->json('documents')->nullable(); // Documents joints
            $table->enum('status', ['submitted', 'in_progress', 'accepted', 'rejected'])->default('submitted');
            $table->text('admin_notes')->nullable(); // Notes de l'admin
            $table->decimal('commission_amount', 8, 2)->default(0); // Commission EduConnect
            $table->boolean('commission_paid')->default(false);
            $table->timestamp('submitted_at');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
