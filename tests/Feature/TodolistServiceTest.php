<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use illuminate\support\Facades\Session;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setup(): void
    {
        parent::setUp();
        // objek todolist diinisialisasi agar menerapkan seluruh fungsi todolistserviceimpl
        // this->app->make bisa digunakan karena service provider todolist sudah di registrasikan kedalah app
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function test_entity()
    {
        self::assertNotNull($this->todolistService);
    }

    public function test_add()
    {
        $this->todolistService->addTodo("1", "Hanif");
        $dtTodo = Session::get("todolist");
        self::assertNotNull($dtTodo);
        foreach ($dtTodo as $val) {
            self::assertEquals("1", $val["id"]);
            self::assertEquals("Hanif", $val["todo"]);
        }
    }

    public function test_getempty()
    {
        self::assertEquals([], $this->todolistService->getTodo());
    }

    public function test_notempty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Hanif"
            ],
            [
                "id" => "2",
                "todo" => "Kusuma"
            ]
        ];

        $this->todolistService->addTodo("1", "Hanif");
        $this->todolistService->addTodo("2", "Kusuma");

        self::assertEquals($expected, $this->todolistService->getTodo());
    }

    public function test_remove()
    {

        $expected = [
            [
                "id" => "1",
                "todo" => "Hanif"
            ],
            [
                "id" => "2",
                "todo" => "Kusuma"
            ]
        ];

        // simulasi hapus index out of number
        $this->todolistService->addTodo("1", "Hanif");
        $this->todolistService->addTodo("2", "Kusuma");

        $this->todolistService->removeTodo("3");

        self::assertEquals($expected, $this->todolistService->getTodo());

        $this->todolistService->removeTodo("1");
        unset($expected[0]);
        self::assertEquals($expected, $this->todolistService->getTodo());

        $this->todolistService->removeTodo("2");
        unset($expected[1]);
        self::assertEquals($expected, $this->todolistService->getTodo());
    }
}
