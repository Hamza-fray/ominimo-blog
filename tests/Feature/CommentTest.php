<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->post("/posts/{$post->id}/comments", [
            'comment' => 'Great post!',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('comments', ['comment' => 'Great post!']);
    }

    public function test_guest_can_comment(): void
    {
        $post = Post::factory()->create();

        $response = $this->post("/posts/{$post->id}/comments", [
            'comment' => 'Guest comment',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('comments', ['comment' => 'Guest comment']);
    }

    public function test_comment_owner_can_delete_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete("/comments/{$comment->id}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_post_owner_can_delete_any_comment_on_their_post(): void
    {
        $postOwner = User::factory()->create();
        $commenter = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $postOwner->id]);
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $commenter->id,
        ]);

        $response = $this->actingAs($postOwner)->delete("/comments/{$comment->id}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_admin_can_delete_any_comment(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $response = $this->actingAs($admin)->delete("/comments/{$comment->id}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
