<?php

namespace Tests\Feature;

use App\Models\Reading;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_readings_list()
    {
        Reading::factory()->count(3)->create();
        $response = $this->getJson('/api/readings');
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_show_returns_single_reading()
    {
        $reading = Reading::factory()->create();
        $response = $this->getJson("/api/readings/{$reading->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $reading->id]);
    }

    public function test_show_returns_404_for_missing_reading()
    {
        $response = $this->getJson('/api/readings/999');
        $response->assertStatus(404);
    }

    public function test_store_creates_new_reading()
    {
        $data = [
            'title' => 'テストタイトル',
            'read_on' => '2025-08-21',
            'impression' => '感想テスト',
        ];
        $response = $this->postJson('/api/readings', $data);
        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'テストタイトル']);
        $this->assertDatabaseHas('readings', ['title' => 'テストタイトル']);
    }

    public function test_store_validation_error()
    {
        $data = [
            'title' => '', // 必須
            'read_on' => '', // 必須
        ];
        $response = $this->postJson('/api/readings', $data);
        $response->assertStatus(422);
    }

    public function test_update_modifies_reading()
    {
        $reading = Reading::factory()->create();
        $data = [
            'title' => 'タイトル更新！',
        ];
        $response = $this->putJson("/api/readings/{$reading->id}", $data);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'タイトル更新！']);
        $this->assertDatabaseHas('readings', ['id' => $reading->id, 'title' => 'タイトル更新！']);
    }

    public function test_update_returns_404_for_missing_reading()
    {
        $data = [
            'title' => '更新タイトル',
        ];
        $response = $this->putJson('/api/readings/999', $data);
        $response->assertStatus(404);
    }

    public function test_update_validation_error()
    {
        $reading = Reading::factory()->create();
        $data = [
            'title' => '', // 必須
        ];
        $response = $this->putJson("/api/readings/{$reading->id}", $data);
        $response->assertStatus(422);
    }

    public function test_destroy_deletes_reading()
    {
        $reading = Reading::factory()->create();
        $response = $this->deleteJson("/api/readings/{$reading->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Deleted']);
        $this->assertDatabaseMissing('readings', ['id' => $reading->id]);
    }

    public function test_destroy_returns_404_for_missing_reading()
    {
        $response = $this->deleteJson('/api/readings/999');
        $response->assertStatus(404);
    }
}

