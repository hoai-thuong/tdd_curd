<?php

namespace Tests\Feature;

use App\Http\Traits\Route;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use Route;

    /** @test */
    public function unauthenticate_user_can_not_see_edit_form ()
    {
        $task = Task::factory()->create();  //create one tasks record
        $response = $this->get($this->getEditRoute($task->id));
        $response->assertStatus(Response::HTTP_FOUND);  //unauthenticate
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticate_user_can_see_edit_form ()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();  //create one tasks record
        $response = $this->get($this->getEditRoute($task->id));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('tasks.edit');
        $response->assertSee('Edit task');
    }

    /** @test */
    public function unauthenticate_user_can_not_edit_form ()
    {
        $task = Task::factory()->create();  //create one tasks record
        $task->name = Str::random(5) . ' updated';  //what is this ?????
        $response = $this->put($this->getEditRoute($task->id), $task->toArray());
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticate_user_can_edit_form ()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();  //create one tasks record
        $name = Str::random(5) . ' updated';  //what is this ?????
        $task->name = $name;
        $response = $this->put($this->getEditRoute($task->id), $task->toArray());
        $response->assertStatus(Response::HTTP_FOUND);
        //check update the tasks
        $data = ['id' => $task->id,
            'name' => $name];
        $this->assertDatabaseHas('tasks', $data);
        $response->assertRedirect($this->getIndexRoute());
    }

    /** @test */

    public function authenticated_user_can_not_edit_tasks_if_name_field_is_null ()
    {
        $this->actingAs(User::factory()->create());
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();  //create one tasks record
        $data = [
            'name' => null,
            'content' => $task->content
        ];
        $respone = $this->put($this->getEditRoute($task->id), $data);
        $respone->assertSessionHasErrors('name');
    }

    public function authenticate_user_can_not_edit_tasks_if_name_is_already_existed ()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();  //create one tasks record
        $name = Str::random(5) . ' updated';  //what is this ?????
        $task->name = $name;
        $response = $this->put($this->getEditRoute($task->id), $task->toArray());
        $response->assertStatus(Response::HTTP_FOUND);
        //check update the tasks
        $data = ['id' => $task->id,
            'name' => $name];
        $this->assertDatabaseHas('tasks', $data);
        $response->assertRedirect($this->getIndexRoute());
    }

}

