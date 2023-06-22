<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface
{

    public function allTodos()
    {
        return Todo::get();
    }

    public function createTodo($data)
    {
        $data['status'] = "Active";

        return Todo::create($data);
    }

    public function findTodo($id)
    {
        return Todo::find($id);
    }

    public function updateTodo($data, $id)
    {
        $item = Todo::where('id', $id)->first();

        logger()->info($item);

        $item->description = $data['description'];
        $item->status = $data['status'];
        $item->save();

        return $item;
    }

    public function destroyTodo($id)
    {
        $item = Todo::find($id);
        $item->delete();
    }

}