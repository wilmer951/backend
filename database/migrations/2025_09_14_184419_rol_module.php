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
        Schema::create('rol_module', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rol_id')->references('id')->on('rol')->onDelete('cascade');
            $table->foreignId('module_id')->references('id')->on('module')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_module');
    }
};
