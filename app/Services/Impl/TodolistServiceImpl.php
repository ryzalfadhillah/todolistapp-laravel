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
}
