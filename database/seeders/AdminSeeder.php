<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nama_user' => "admin",
            'password' => "12345678",
            'email' => "admin@gmail.com",
            'nomor_telp' => 1234567890,
            'role' => 1,
            'status' => 1

        ]);
        $user->assignRole('admin');

    }
}
