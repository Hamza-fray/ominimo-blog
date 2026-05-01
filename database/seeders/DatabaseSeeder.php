<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(5)->create();

        foreach ($users as $user) {
            $posts = Post::factory(3)->create(['user_id' => $user->id]);

            foreach ($posts as $post) {
                Comment::factory(4)->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}
