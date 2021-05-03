<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    public function run()
    {
        DB::table('team')->insert(['name_team' => 'ABC/RN', 'city_team' => 'Natal/RN', 'team_status' => 1, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('team')->insert(['name_team' => 'Alecrim/RN', 'city_team' => 'Natal/RN', 'team_status' => 0, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('team')->insert(['name_team' => 'América/RN', 'city_team' => 'Natal/RN', 'team_status' => 1, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('team')->insert(['name_team' => 'Vasco da Gama/RJ', 'city_team' => 'Rio de Janeiro/RJ', 'team_status' => 0, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('team')->insert(['name_team' => 'Flamengo/RJ', 'city_team' => 'Rio de Janeiro/RN', 'team_status' => 1, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('team')->insert(['name_team' => 'São Paulo/SP', 'city_team' => 'São Paulo/SP', 'team_status' => 1, 'created_at' => now(), 'updated_at' => now()]);
    }
}
