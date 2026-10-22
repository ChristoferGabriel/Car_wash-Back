<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anexo_agendamento', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->integer('id', true);
            $table->integer('agendamento_id');
            $table->string('url', 255);
            $table->timestamp('created_at')->nullable();

            $table->foreign('agendamento_id', 'fk_anexo_agendamento_agendamento')
                ->references('id')->on('agendamento')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anexo_agendamento');
    }
};
