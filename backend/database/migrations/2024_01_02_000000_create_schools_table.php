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
            $table->text('address');
            $table->string('city');
            $table->string('country');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner_image')->nullable();
            $table->integer('established_year')->nullable();
            $table->json('accreditations')->nullable();
            $table->json('facilities')->nullable();
            $table->json('admission_requirements')->nullable();
            $table->decimal('application_fee', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['city', 'country']);
            $table->index('is_active');
            $table->index('application_fee');
            $table->fullText(['name', 'description']);
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
