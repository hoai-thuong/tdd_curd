<?php

namespace Tests\Feature;

use App\Http\Traits\Route;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateNewTaskTest extends TestCase
{
    use Route;

    /** @test */
    public function authenticated_user_can_create_new_task ()
    {
        //create example record
        $this->actingAs(User::factory()->create());  //have login
        $task = Task::factory()->make()->toArray(); //using make instead of create because using create will be store in data base
        $response = $this->post($this->getStoreRoute(), $task);
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('tasks', $task);
        $response->assertRedirect($this->getIndexRoute());
    }
    /** @test */
    // have to have m
    public function unauthenticated_user_can_not_create_new_task ()
    {
        $task = Task::factory()->make()->toArray(); //using make instead of create because using create will be store in data base
        $response = $this->post($this->getStoreRoute(), $task);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticate_user_can_not_create_task_if_name_field_is_null ()
    {
        $this->actingAs(User::factory()->create());  //have login
        $task = Task::factory()->make(['name' => null])->toArray(); //using make instead of create because using create will be store in data base
        $response = $this->post($this->getStoreRoute(), $task);
        $response->assertSessionHasErrors(['name']);  //error in TaskController:store
    }

    /** @test */
    public function authenticated_user_can_view_create_tasks_form ()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get($this->getCreateRoute());
        $response->assertViewIs('tasks.create');
    }

    /** @test */
    public function authenticated_user_can_see_name_required_text_if_validate_error ()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->make(['name' => null])->toArray(); //using make instead of create because using create will be store in data base
        $response = $this->from($this->getCreateRoute())->post($this->getStoreRoute(), $task);
        $response->assertRedirect($this->getCreateRoute());
//        $response->assertSee('The name field is required.')
    }

    /** @test  */
    public function unauthenticated_user_can_not_see_create_task_form_view ()
    {
        $task = Task::factory()->make(['name' => null])->toArray(); //using make instead of create because using create will be store in data base
        $response = $this->get($this->getCreateRoute());
        $response->assertRedirect('/login');
    }



//    public function getCreateTaskViewRoute() {
//        return route('tasks.create');
//    }
//
//
//    public function getCreateTaskRoute ()
//    {
//        return route('tasks.store');
//    }
}
