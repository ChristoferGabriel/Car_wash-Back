<?php

use App\Models\Servico;

it('lista só os serviços ativos, sem precisar de login', function () {
    Servico::create(['nome' => 'Lavagem de Muros']);
    Servico::create(['nome' => 'Serviço desativado', 'ativo' => false]);

    $this->getJson('/api/servicos')
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonStructure([['id', 'nome', 'descricao']])
        ->assertJsonFragment(['nome' => 'Lavagem de Muros'])
        ->assertJsonMissing(['nome' => 'Serviço desativado']);
});

it('devolve lista vazia quando não há serviços ativos', function () {
    $this->getJson('/api/servicos')
        ->assertOk()
        ->assertExactJson([]);
});