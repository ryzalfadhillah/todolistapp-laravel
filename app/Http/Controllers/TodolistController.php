<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TodolistController extends Controller
{
    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todolist(Request $request)
    {
        $todolist = $this->todolistService->getTodolist();
        return response()->view('todolist.todolist', [
            'title' => 'Todolist',
            'todolist' => $todolist
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input('todo');

        if (empty($todo)) {
            return Redirect('/todolist')->with('error', 'Todo is required');
        }

        $this->todolistService->saveTodo(uniqid(), $todo);
        // return redirect()->action([TodolistController::class, 'todolist'])->with('success', 'Todo added successfully');
        return Redirect('/todolist')->with('success', 'Todo added successfully');
    }

    public function deleteTodo(Request $request, string $id)
    {
        $this->todolistService->deleteTodo($id);
        return Redirect('/todolist')->with('success', 'Delete successfully');
    }
}
