<?php
namespace App\Repositories\Interfaces;

Interface TodoRepositoryInterface{
    
    public function allTodos();
    public function createTodo($data);
    public function findTodo($id);
    public function updateTodo($data, $id); 
    public function destroyTodo($id);
}