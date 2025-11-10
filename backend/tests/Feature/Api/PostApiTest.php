<?php

namespace Tests\Feature\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_list_posts(): void
    {
        $user = User::factory()->create();
        Post::factory(3)->for($user)->create();

        $response = $this->getJson('/api/v1/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'content',
                        'status',
                        'user_id',
                        'created_at',
                        'updated_at',
                        'user',
                    ],
                ],
                'current_page',
                'total',
            ]);
    }

    public function test_can_create_post(): void
    {
        $user = User::factory()->create();
        $postData = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'status' => 'published',
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/v1/posts', $postData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'content',
                'status',
                'user_id',
                'created_at',
                'updated_at',
                'user',
            ])
            ->assertJson([
                'title' => $postData['title'],
                'content' => $postData['content'],
                'status' => $postData['status'],
                'user_id' => $user->id,
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => $postData['title'],
            'user_id' => $user->id,
        ]);
    }

    public function test_can_show_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $response = $this->getJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
                'content',
                'status',
                'user_id',
                'created_at',
                'updated_at',
                'user',
            ])
            ->assertJson([
                'id' => $post->id,
                'title' => $post->title,
                'user_id' => $user->id,
            ]);
    }

    public function test_can_update_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();
        $updateData = [
            'title' => 'Updated Title',
            'status' => 'published',
        ];

        $response = $this->patchJson("/api/v1/posts/{$post->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $post->id,
                'title' => 'Updated Title',
                'status' => 'published',
            ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'status' => 'published',
        ]);
    }

    public function test_can_delete_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $response = $this->deleteJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_post_creation_validation(): void
    {
        $response = $this->postJson('/api/v1/posts', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'content', 'user_id']);
    }

    public function test_can_filter_posts_by_status(): void
    {
        $user = User::factory()->create();
        Post::factory()->for($user)->create(['status' => 'draft']);
        Post::factory()->for($user)->create(['status' => 'published']);

        $response = $this->getJson('/api/v1/posts?status=published');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['status' => 'published']);
    }

    public function test_can_search_posts(): void
    {
        $user = User::factory()->create();
        Post::factory()->for($user)->create(['title' => 'Laravel Tutorial']);
        Post::factory()->for($user)->create(['title' => 'PHP Basics']);

        $response = $this->getJson('/api/v1/posts?search=Laravel');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['title' => 'Laravel Tutorial']);
    }
}
