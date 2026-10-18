<?php

namespace Database\Seeders;

use App\Models\Servico;
use Illuminate\Database\Seeder;

class ServicoSeeder extends Seeder
{
    public function run(): void
    {
        $servicos = [
            'Lavagem de Muros e Paredes Externas',
            'Lavagem de Portões e Grades',
            'Lavagem de Fachadas e Revestimentos',
            'Lavagem de Calçadas e Pisos Externos',
            'Lavagem de Pedras e Revestimentos',
            'Lavagem de Garagens e Áreas de Circulação',
            'Lavagem de Áreas de Lazer',
            'Lavagem de Áreas PET e Espaços Externos',
        ];

        foreach ($servicos as $nome) {
            Servico::firstOrCreate(['nome' => $nome]);
        }
    }
}
