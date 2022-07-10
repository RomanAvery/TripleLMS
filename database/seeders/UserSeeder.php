<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Only create one admin
        $user = User::where('email', 'admin@demo.com')->get()->first();
        if ($user !== null) return;

        $user = User::create([
            'name' => 'Admin Demo',
            'email' => 'admin@demo.com',
            'password' => \Hash::make('demo'),
        ]);
        $user->assignRole('admin');
    }
}
