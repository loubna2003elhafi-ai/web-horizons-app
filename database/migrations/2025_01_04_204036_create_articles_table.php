<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu');
            $table->enum('statut', ['Brouillon', 'En cours', 'Retenu', 'Publié', 'Refusé', 'Désactivé']);
            $table->date('date_proposition');
            $table->date('date_proposition_editeur')->nullable();
            $table->date('date_publication')->nullable();
            $table->string('image_couverture')->nullable();
            $table->integer('temps_lecture')->nullable();
            $table->integer('vues')->default(0);
            $table->text('motif_rejet')->nullable();
            $table->foreignId('theme_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('numero_id')->nullable()->references('Id_numero')->on('numeros')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
