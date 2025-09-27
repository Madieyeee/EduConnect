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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('city');
            $table->string('address');
            $table->string('postal_code');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->json('fields_of_study'); // Filières d'étude
            $table->json('accreditations'); // Accréditations
            $table->json('diplomas'); // Diplômes proposés
            $table->decimal('tuition_fee_min', 10, 2)->nullable(); // Frais de scolarité minimum
            $table->decimal('tuition_fee_max', 10, 2)->nullable(); // Frais de scolarité maximum
            $table->decimal('application_fee', 8, 2)->default(0); // Frais de dossier
            $table->text('admission_requirements')->nullable(); // Conditions d'admission
            $table->date('next_intake')->nullable(); // Prochaine rentrée
            $table->string('logo')->nullable(); // Logo de l'école
            $table->json('images')->nullable(); // Images de l'école
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
