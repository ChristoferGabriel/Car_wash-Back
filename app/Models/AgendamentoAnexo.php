<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;

class AgendamentoAnexo extends Model
{
    protected $table = 'agendamento_anexos';

    protected $fillable = ['agendamento_id', 'caminho', 'nome_original', 'mime_type', 'tamanho'];
    
    protected $hidden = ['caminho'];

    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(Agendamento::class);
    }

    public function urlTemporaria(int $minutos = 10): string
    {
        return URL::temporarySignedRoute(
            'anexos.show',
            now()->addMinutes($minutos),
            ['anexo' => $this->id]
        );
    }
}