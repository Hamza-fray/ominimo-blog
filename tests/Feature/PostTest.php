<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_posts(): void
    {
        $post = Post::factory()->create();
        $response = $this->get('/posts');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'Test Post',
            'content' => 'Test content',
        ]);
        $response->assertRedirect('/posts');
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    public function test_guest_cannot_create_post(): void
    {
        $response = $this->post('/posts', [
            'title' => 'Test Post',
            'content' => 'Test content',
        ]);
        $response->assertRedirect('/login');
    }

    public function test_owner_can_update_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put("/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ]);
        $response->assertRedirect("/posts/{$post->id}");
        $this->assertDatabaseHas('posts', ['title' => 'Updated Title']);
    }

    public function test_non_owner_cannot_update_post(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)->put("/posts/{$post->id}", [
            'title' => 'Hacked Title',
            'content' => 'Hacked content',
        ]);
        $response->assertStatus(403);
    }

    public function test_owner_can_delete_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/posts/{$post->id}");
        $response->assertRedirect('/posts');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_admin_can_delete_any_post(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin)->delete("/posts/{$post->id}");
        $response->assertRedirect('/posts');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_post_creation_requires_title_and_content(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/posts', []);
        $response->assertSessionHasErrors(['title', 'content']);
    }
}
