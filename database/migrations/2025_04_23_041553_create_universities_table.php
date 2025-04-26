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
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->text('description')->nullable();
            $table->string('country');
            $table->string('city');
            $table->integer('ranking')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->year('founded')->nullable();
            $table->enum('type', ['public', 'private'])->nullable();
            $table->integer('no_of_students')->nullable();
            $table->json('image')->nullable();
            $table->string('website_link')->nullable();
            $table->string('slug')->unique();
            $table->string('application_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
