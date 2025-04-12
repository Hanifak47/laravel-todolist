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

    public function getTodo(): array
    {
        $dt = Session::get("todolist", []);
        return $dt;
    }

    public function removeTodo(string $id)
    {
        $dt = $this->getTodo();
        foreach ($dt as $ix => $val) {
            if ($val['id'] == $id) {
                unset($dt[$ix]);
                break;
            }
        }

        Session::put("todolist", $dt);
    }
}
