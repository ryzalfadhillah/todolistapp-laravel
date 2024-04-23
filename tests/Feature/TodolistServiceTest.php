<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    public function setUp(): void
    {
        parent::setUp();
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo('1', 'Belajar Laravel');
        $this->todolistService->saveTodo('2', 'Belajar PHP');
        $this->todolistService->saveTodo('3', 'Belajar Java');

        $todolists = session('todolists');
        self::assertCount(3, $todolists);

        self::assertEquals('1', $todolists[0]['id']);
        self::assertEquals('Belajar Laravel', $todolists[0]['todo']);

        self::assertEquals('2', $todolists[1]['id']);
        self::assertEquals('Belajar PHP', $todolists[1]['todo']);

        self::assertEquals('3', $todolists[2]['id']);
        self::assertEquals('Belajar Java', $todolists[2]['todo']);
    }

    public function testGetTodolistEmpty()
    {
        $todolists = $this->todolistService->getTodolist();
        self::assertEmpty($todolists);
    }

    public function testGetTodolist()
    {
        $expected = [
            ['id' => '1', 'todo' => 'Belajar Laravel'],
            ['id' => '2', 'todo' => 'Belajar PHP'],
            ['id' => '3', 'todo' => 'Belajar Java']
        ];

        $this->todolistService->saveTodo('1', 'Belajar Laravel');
        $this->todolistService->saveTodo('2', 'Belajar PHP');
        $this->todolistService->saveTodo('3', 'Belajar Java');

        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testDeleteTodo()
    {
        $this->todolistService->saveTodo('1', 'Belajar Laravel');
        $this->todolistService->saveTodo('2', 'Belajar PHP');
        $this->todolistService->saveTodo('3', 'Belajar Java');

        $this->todolistService->deleteTodo('4');

        self::assertEquals(3, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->deleteTodo('2');

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));
    }
}
