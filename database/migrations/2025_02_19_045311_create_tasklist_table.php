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
        Schema::create('tasklist', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category')->constrained('task_categories');
            $table->string('description');
            $table->string('status');
            $table->foreignId('assigned_to')->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('completed_by')->constrained('users');
            $table->foreignId('deleted_by')->constrained('users');
            $table->boolean('deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasklist');
    }
};
