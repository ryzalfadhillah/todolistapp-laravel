<?php

namespace App\Services\Impl;

use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService
{
    public function saveTodo(string $id, string $todo): void
    {
        if (!Session::has('todolists')) {
            Session::put('todolists', []);
        }

        Session::push('todolists', [
            'id' => $id,
            'todo' => $todo
        ]);
    }

    public function getTodolist(): array
    {
        return Session::get('todolists', []);
    }

    public function deleteTodo(string $id)
    {
        $todolists = Session::get('todolists', []);

        foreach ($todolists as $todo => $todolist) {
            if ($todolist['id'] === $id) {
                unset($todolists[$todo]);
                break;
            }
        }

        Session::put('todolists', $todolists);
    }
}
