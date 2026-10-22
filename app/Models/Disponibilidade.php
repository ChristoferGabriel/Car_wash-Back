<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disponibilidade extends Model
{
    protected $table = 'disponibilidade';

    public $timestamps = false;

    protected $fillable = ['data', 'hora_inicio', 'hora_fim', 'capacidade', 'observacao'];
    
    protected function casts(): array
    {
        return [
            'data' => 'date:Y-m-d',
            'capacidade' => 'integer',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
