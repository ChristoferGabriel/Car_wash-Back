<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'cliente';

    protected $fillable = [
        'nome', 'telefone', 'email', 'senha_hash', 'tipo', 'aceite_termos_em',
    ];

    protected $hidden = ['senha_hash'];

    protected function casts(): array
    {
        return [
            'senha_hash' => 'hashed',
            'aceite_termos_em' => 'datetime',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'senha_hash';
    }

    protected function telefone(): Attribute
    {
        return Attribute::set(
            fn (?string $valor) => $valor === null ? null : preg_replace('/\D/', '', $valor)
        );
    }

    public function enderecos(): HasMany
    {
        return $this->hasMany(Endereco::class);
    }

    public function agendamentos(): HasMany
    {
        return $this->hasMany(Agendamento::class);
    }
}
