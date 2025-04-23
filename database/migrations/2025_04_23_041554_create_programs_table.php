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
            $table->foreignId('university_id')->constrained('universities');
            $table->string('name');
            $table->json('detail');
            $table->string('degree_type');
            $table->string('duration');
            $table->json('application_requirement');
            $table->string('intake');
            $table->enum('payment_plan', ['monthly', 'per_semester', 'no_installements']);
            $table->timestamps();
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
