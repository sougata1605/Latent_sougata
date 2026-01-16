<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task_success()
    {
       
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'status' => 'pending',
        ]);

        $response->assertStatus(201);
    }
}
