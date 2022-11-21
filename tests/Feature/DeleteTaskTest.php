<?php

namespace Tests\Feature;

use App\Http\Traits\Route;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteTaskTest extends TestCase
{
    use Route;
    /** @test */
    public function unauthenticated_user_can_delete_tasks()
    {
        $task = Task::factory()->create();
        $response = $this->delete($this->getDestroyRoute($task->id));
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }
    /** @test */
    public function authenticated_user_can_delete_tasks()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $response = $this->delete($this->getDestroyRoute($task->id));
        $response->assertStatus(Response::HTTP_FOUND);
//        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('tasks', $task->toArray());
        $response->assertRedirect($this->getIndexRoute());
    }

}
