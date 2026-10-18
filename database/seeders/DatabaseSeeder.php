<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ServicoSeeder::class);

        $email = config('admin.email');
        $password = config('admin.password');

        if (blank($email) || blank($password)) {
            $this->command->warn('ADMIN_EMAIL/ADMIN_PASSWORD não definidos: admin não foi criado.');
            return;
        }

        if (strlen($password) < 12) {
            $this->command->error('ADMIN_PASSWORD precisa ter ao menos 12 caracteres.');
            return;
        }

        $admin = User::firstOrNew(['email' => $email]);

        if (! $admin->exists) {
            $admin->name = config('admin.name');
            $admin->password = Hash::make($password);
            $admin->save();
        }
    }
}