<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('abTestVariables', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->foreignId('abTestId')->constrained('abTests', 'id')->cascadeOnDelete();
            $table->float('ratio');
            $table->integer('visitors')->default(0);
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abTestVariables');
    }
};
