<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'CORMAN',
            'username' => 'corman',
            'email' => 'corman@example.com',
            'password' => Hash::make('corman'),
        ])->assignRole('Corman');

        User::create([
            'name' => 'MOVIL24',
            'username' => 'movil24',
            'email' => 'movil24@example.com',
            'password' => Hash::make('movil24'),
        ])->assignRole('Operario');

        User::create([
            'name' => 'Angel',
            'username' => 'angel',
            'email' => 'angel@example.com',
            'password' => Hash::make('angel'),
        ])->assignRole('Facilitie');
    }
}
