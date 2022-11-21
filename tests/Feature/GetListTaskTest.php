<?php

namespace Tests\Feature;

use App\Http\Traits\Route;
use App\Models\Task;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetListTaskTest extends TestCase
{
    use Route;
    //create function to when we want to change route just need to change in this function

    /**
     * @test
     */
    //user can get all data from database
    public function user_can_get_all_task ()
    {
        $task = Task::factory()->create();  //create records
//        $response = $this->get('/tasks');
        $response = $this->get($this->getIndexRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('tasks.index');
        $response->assertSee($task->name);

    }
}
