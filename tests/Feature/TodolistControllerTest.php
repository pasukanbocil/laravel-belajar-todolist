<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{

    public function testTodolist()
    {
        $this->withSession([
            "user" => "Dicky",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Satria"
                ],
                [
                    "id" => "2",
                    "todo" => "Nissa"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Satria")
            ->assertSeeText("2")
            ->assertSeeText("Nissa");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "Khannedy",
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "Khannedy"
        ])->post("/todolist", [
            "todo" => "Eko"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodo()
    {
        $this->withSession([
            "user" => "Dicky",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Satria"
                ],
                [
                    "id" => "2",
                    "todo" => "Nissa"
                ]
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }
}
