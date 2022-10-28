<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $test = User::factory()->create([
            'id' => '00000000-0000-0000-0000-000000000000',
            'name' => 'Guest',
            'email' => 'test@example.com',
        ]);
        User::factory(5)->create();
    }
}
