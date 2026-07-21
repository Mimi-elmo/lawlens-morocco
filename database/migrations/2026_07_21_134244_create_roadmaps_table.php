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
        Schema::create('roadmaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('forme_juridique_recommandee_id')->nullable()->constrained('legal_structures')->nullOnDelete();
            $table->text('resume')->nullable();
            $table->longText('reponse_IA')->nullable();
            $table->string('statut')->default('pending');
            $table->integer('progression')->default(0);
            $table->timestamp('date_generation')->nullable();
            $table->timestamps();
            $table->index('project_id');
            $table->index('forme_juridique_recommandee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmaps');
    }
};
