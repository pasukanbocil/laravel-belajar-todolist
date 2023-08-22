<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\TodolistService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;



class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }
    public function testTodolisNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "Dicky");

        $todolist = Session::get("todolist");
        foreach ($todolist as $value) {
            self::assertEquals("1", $value["id"]);
            self::assertEquals("Dicky", $value["todo"]);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Dicky"
            ],
            [
                "id" => "2",
                "todo" => "Satria"
            ],
        ];

        $this->todolistService->saveTodo("1", "Dicky");
        $this->todolistService->saveTodo("2", "Satria");

        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo("1", "Dicky");
        $this->todolistService->saveTodo("2", "Satria");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("3");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("1");

        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("2");

        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
