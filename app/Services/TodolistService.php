<?php

namespace App\Services;

interface TodolistService
{
    public function addTodo(string $id, string $todo): void;

    public function getTodo(): array;

    public function removeTodo(string $id);

}
