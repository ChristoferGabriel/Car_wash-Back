<?php

namespace App\Models;

use App\Enums\StatusAgendamento;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Agendamento extends Model
{
    protected $table = 'agendamento';

    protected $fillable = [
        'cliente_id', 'endereco_id', 'data_hora', 'data_hora_fim', 'observacoes',
    ];

    protected $attributes = [
        'status' => 'pendente',
    ];

    protected function casts(): array
    {
        return [
            'data_hora' => 'datetime',
            'data_hora_fim' => 'datetime',
            'status' => StatusAgendamento::class,
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function endereco(): BelongsTo
    {
        return $this->belongsTo(Endereco::class);
    }

    public function servicos(): BelongsToMany
    {
        return $this->belongsToMany(Servico::class, 'agendamento_servico')
            ->withPivot('preco_unitario');
    }

    public function anexos(): HasMany
    {
        return $this->hasMany(AgendamentoAnexo::class);
    }

    public function scopePendentes(Builder $query): Builder
    {
        return $query->where('status', StatusAgendamento::Pendente->value);
    }

    protected static function booted(): void
    {
        static::deleting(function (Agendamento $agendamento) {
            $agendamento->anexos->each(
                fn ($anexo) => Storage::disk('local')->delete($anexo->url)
            );
        });
    }
}
