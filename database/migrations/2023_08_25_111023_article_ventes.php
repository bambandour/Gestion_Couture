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
        Schema::create('article_ventes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->unique();
            $table->integer('prix_vente');
            $table->integer('cout_fabrication');
            $table->float('marge');
            $table->integer('stock')->nullable();
            $table->foreignId('categorie_id')->constrained('categorie_confections')->cascadeOnDelete();
            $table->boolean('promo')->default(false);
            $table->string('photo')->nullable();
            $table->string('reference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_ventes');
    }
};
