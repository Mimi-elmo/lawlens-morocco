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
        Schema::create('legal_structure_rule', function (Blueprint $table) {
            $table->foreignId('legal_structure_id')->constrained()->cascadeOnDelete();
            $table->foreignId('legal_rule_id')->constrained()->cascadeOnDelete();
            $table->primary(['legal_structure_id', 'legal_rule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_structure_rule');
    }
};
