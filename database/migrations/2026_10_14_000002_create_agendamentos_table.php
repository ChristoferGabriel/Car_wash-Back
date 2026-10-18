<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 100);
            $table->string('telefone', 20);
            $table->string('endereco', 255);
            $table->foreignId('servico_id')->constrained('servicos')->restrictOnDelete();
            $table->date('data');
            $table->time('horario');

            $table->string('status', 20)->default('pendente');
            $table->text('observacoes')->nullable();

            $table->timestamps();

            $table->index(['data', 'horario']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
