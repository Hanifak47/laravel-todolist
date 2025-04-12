<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
// use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class TodolistController extends Controller
{

    private TodolistService $todoList;

    public function __construct(TodolistService $todoList)
    {
        $this->todoList = $todoList;
    }

    //
    public function indexTodo(Request $request)
    {
        $dttodo = $this->todoList->getTodo();
        return response()
            ->view('todolist.todolist', [
                'title' => 'Daftar Todo',
                'todos' => $dttodo
            ])
        ;

    }

    public function addTodo(Request $request)
    {

        $todo = $request->input('todo');
        if (empty($todo)) {
            $listtodo = $this->todoList->getTodo();
            return response()
                ->view('todolist.todolist', [
                    'title' => 'Daftar Todo',
                    'todo' => $listtodo,
                    'error' => 'Todo is required'
                ])
            ;
        }
        
        $this->todoList->addTodo(uniqid(),$todo);
        return redirect('/todo/index');
        // return redirect()->action([TodolistController::class, 'indexTodo']);
    }

    public function removeTodo(Request $request, string $id)
    {
        $this->todoList->removeTodo($id);
        return redirect('/todo/index');
    }
}
