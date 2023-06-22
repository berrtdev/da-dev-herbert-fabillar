<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Http\Resources\TodoResource;
use App\Http\Resources\TodoCollectionResource;
use App\Http\Requests\TodoPostRequest;

class TodoController extends Controller
{
    private $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        try {

            $todos = $this->todoRepository->allTodos();

            $resp = [];

            if(count($todos) > 0) {
                $resp = new TodoCollectionResource($todos);
            } 
            
            return response()->json([
                "success" => true,
                "data" => $resp
            ]);

        } catch (Exception $e) {
            logger()->error($e->getMessage());

            abort(403, 'Something went wrong, contact support!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoPostRequest $request)
    {
        $data = $request->validated();
        logger()->info($data);

        try {

            $resp = $this->todoRepository->createTodo($data);

            return response()->json([
                "success" => true,
                "data" => new TodoResource($resp)
            ]);

        } catch (Exception $e) {
            logger()->error($e->getMessage());

            abort(403, 'Something went wrong, contact support!');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $resp = $this->todoRepository->findTodo($id);

            if($resp) {
                return response()->json([
                    "success" => true,
                    "data" => new TodoResource($resp)
                ]);
            }

            return response()->json([
                "success" => false,
                "message" => "No data found!",
            ]);

        } catch (Exception $e) {
            logger()->error($e->getMessage());

            abort(403, 'Something went wrong, contact support!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoPostRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $resp = $this->todoRepository->updateTodo($data, $id);

            return response()->json([
                "success" => true,
                "data" => new TodoResource($resp)
            ]);            

        } catch (Exception $e) {
            logger()->error($e->getMessage());

            abort(403, 'Something went wrong, contact support!');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $this->todoRepository->destroyTodo($id);

            return response()->json([
                "success" => true,
                "message" => "To-Do Item removed successfully!",
            ]);

        } catch (Exception $e) {
            logger()->error($e->getMessage());

            abort(403, 'Something went wrong, contact support!');
        }

        
    }
}
