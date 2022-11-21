<?php

namespace App\Http\Traits;
trait Route
{
    public function getIndexRoute ()
    {
        return route('tasks.index');
    }

    public function getCreateRoute ()
    {  //getCreateTaskViewRoute
        return route('tasks.create');
    }

    public function getStoreRoute ()
    {  //getCreateTaskRoute
        return route('tasks.store');
    }

    public function getEditRoute ($id)
    {
        return route('tasks.edit', ['id' => $id]);
    }

    public function getUpdateRoute ($id)
    {
        return route('tasks.update', ['id' => $id]);
    }

    public function getDestroyRoute ($id)
    {
        return route('tasks.destroy', ['id' => $id]);
    }


}

