<?php

namespace App\Services\Impl;

use App\Services\TodolistService;
use Illuminate\support\Facades\Session;

class TodolistServiceImpl implements TodolistService
{

    public function addTodo(string $id, string $todo): void
    {
        // jika tidak ada session maka buat session
        if (!Session::exists("todolist")) {
            Session::put("todolist", []);
        }

        Session::push("todolist", [
            "id" => $id,
            "todo" => $todo
        ]);

    }
}
