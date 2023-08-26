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
        Schema::create('article_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Article::class)->constrained('articles')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Fournisseur::class)->constrained('fournisseurs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_fournisseurs');
    }
};
