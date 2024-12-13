<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => "Alejandro Milian",
                'email' => "alejandro@gmail.com",
                'role' => "revisor"
            ],
            [
                'name' => "Roberto Garcia",
                'email' => "robgar@gmail.com",
                'role' => "comprador"
            ]
        ];

        foreach ($data as $item) {
            User::create($item);
        }
    }
}
