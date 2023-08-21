<?php

namespace App\Services;

interface TodolistService
{
    public function saveTodo(String $id, string $todo): void;

    public function getTodolist(): array;

    public function removeTodo(string $todoId);
}
