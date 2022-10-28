<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::factory()->create([
            'id' => 'ffffffff-ffff-ffff-ffff-ffffffffffff'
        ]);

        Message::factory()->create([
            'id' => '00000000-0000-0000-0000-000000000000'
        ]);
        Message::factory(10)->create();
    }
}
