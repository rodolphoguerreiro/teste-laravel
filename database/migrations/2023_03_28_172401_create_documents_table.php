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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('category_id') /* Utilizaria foreignId oa invés de bigInteger(),
                                                pois foreignId já cria explicitamente uma nova coluna do tipo bigInteger
                                                além de melhorar e legibilidade do código
                                            */
                ->constrained()
                ->onDelete('cascade'); // Definiria a chave extrangeira explicitamente para em casos de referências futuras

            $table->string('title', 60);
            $table->text('contents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
