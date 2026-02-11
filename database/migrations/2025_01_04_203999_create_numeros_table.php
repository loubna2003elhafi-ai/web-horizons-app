<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('numeros', function (Blueprint $table) {
            $table->id('Id_numero');
            $table->string('titre_numero');
            $table->text('description')->nullable();
            $table->string('image_couverture')->nullable();
            $table->date('date_publication');
            $table->boolean('is_published')->default(false);
            $table->enum('visibilite', ['Public', 'Privé'])->default('Privé');
            $table->string('theme_central')->nullable();
            $table->integer('numero_edition');
            $table->timestamps();
        });

        // // Ajout de la colonne numero_id dans la table articles
        // Schema::table('articles', function (Blueprint $table) {
        //     $table->foreignId('numero_id')->nullable()->constrained('numeros', 'Id_numero')->nullOnDelete();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['numero_id']);
            $table->dropColumn('numero_id');
        });
        
        Schema::dropIfExists('numeros');
    }
};
