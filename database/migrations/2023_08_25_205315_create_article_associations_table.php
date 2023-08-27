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
        Schema::create('article_associations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Article::class)->constrained('articles')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\ArticleVente::class)->constrained('article_ventes')->cascadeOnDelete();
            $table->integer('quantite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_associations');
    }
};
