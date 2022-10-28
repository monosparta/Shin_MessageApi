<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Comment::factory()->create([
            'id' => 'ffffffff-ffff-ffff-ffff-ffffffffffff',
            'message' => 'I am a root!!'
        ]);

        Comment::factory()->create([
            'id' => '00000000-0000-0000-0000-000000000000',
            'message' => 'I am a Guest!!'
        ]);
        Comment::factory(10)->create();
    }
}
