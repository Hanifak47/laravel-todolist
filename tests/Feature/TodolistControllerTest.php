<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_index()
    {
        $this
            ->withSession([
                'user' => 'Hanif',
                'todolist' => [
                    [
                        'id' => '1',
                        'todo' => 'Hanif'
                    ],
                    [
                        'id' => '2',
                        'todo' => 'Kusuma'
                    ]
                ]
            ])
            ->get('/todo/index')
            ->assertSeeText('Daftar Todo')
            ->assertSeeText('1')
            ->assertSeeText('2')
            ->assertSeeText('Hanif')
            ->assertSeeText('Kusuma')
        ;
    }

    public function test_nologin()
    {
        $this->get('/todo/index')
            ->assertRedirect('/user/login')
        ;
    }


    public function test_add_fail()
    {
        $this->withSession([
            'user' => 'Hanif'
        ])
            ->post('/todo/index', [])
            ->assertSeeText('Todo is required')
        ;
    }

    public function test_add_success()
    {
        $this->withSession([
            'user' => 'Hanif'
        ])
            ->post('/todo/add', [
                'todo' => 'Hanif',
            ])
            // ->assertSeeText('Hanif')
            ->assertRedirect('/todo/index')
        ;
    }

    public function test_remove()
    {
        $this->withSession([
            'user' => 'Hanif',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'Hanif'
                ],
                [
                    'id' => '2',
                    'todo' => 'Kusuma'
                ]
            ]
        ])
        ->post('/todo/remove/1')
        ->assertRedirect('/todo/index')
        ;
    }
}
