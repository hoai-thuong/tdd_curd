<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Traits\Route;
use App\Models\Task;

class TaskController extends Controller
{
    use Route;

    protected $task;

    /**
     * @param $task
     */
    public function __construct (Task $task)
    {
        $this->task = $task;
    }

    public function index ()
    {
        $tasks = $this->task::latest('id')->paginate(10);
        return view('tasks.index', compact('tasks'));  //tasks in index
    }

    public function store (CreateTaskRequest $request)
    {
        $this->task->create($request->all()); //data is stored ỉn requ , ->all send input of user send to serg
//        return response()->json([], \Illuminate\Http\Response::HTTP_CREATED);
        return redirect($this->getIndexRoute());
    }

    public function create ()
    {
        return view('tasks.create');
    }

    public function edit ($id)
    {
        $tasks = $this->task::findOrFail($id);
        return view('tasks.edit', compact('tasks'));   //tasks in here is variable using in edit.blade
    }

    //to edit, and insert into database
    public function update (UpdateTaskRequest $request, $id)
    {
        $task = $this->task::findOrFail($id);
        $task->update($request->all());
        return redirect($this->getIndexRoute());
    }

    public function destroy ($id)
    {
        $task = $this->task::findOrFail($id);
        $task->delete();
        return redirect($this->getIndexRoute());
    }

}
