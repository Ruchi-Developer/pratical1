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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID (primary key)
            $table->string('name', 55)->nullable();  // Name (up to 255 characters, nullable)
            $table->string('position', 40);  // Position (up to 255 characters)
            $table->string('department', 45);  // Department (up to 255 characters)
            $table->string('phone', 15)->nullable();  // Phone (up to 15 characters, nullable)
            $table->decimal('salary', 10, 2);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
