<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
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

    // tes jika sudah login dalam artian memiliki session dan akses halaman login
    public function test_middleware_login()
    {
        $this->withSession([
            "user" => "Hanif"
        ])
            ->get('/user/login')
            ->assertRedirect('/')
        ;
    }

    // jika sudah login tidak bisa melakukan proses login lagi
    public function test_middleware_dologin()
    {
        $this->withSession([
            "user" => "Hanif"
        ])
            ->post('/user/login', [
                "user" => "Hanif",
                "password" => "rahasiabro"
            ])
            ->assertRedirect('/')
        ;
    }

    public function test_middleware_dologin_nouname()
    {
        $this->withSession([
            "user" => "Hanif"
        ])
            ->post('/user/login', [
                // "user" => "Hanif",
                // "password" => "rahasiabro"
            ])
            ->assertRedirect('/')
        ;
    }

    public function test_middleware_dologin_wonrguname()
    {
        $this->withSession([
            "user" => "Hanif"
        ])
            ->post('/user/login', [
                "user" => "Hanifa",
                "password" => "rahasiabro"
            ])
            ->assertRedirect('/')
        ;
    }


    // tes saat masuk menu login
    public function test_login_page()
    {
        $this->get('/user/login')
            ->assertSeeText('Login');
        ;
    }

    //tidak ada password dan username 
    public function test_null_unamepw()
    {
        $this->post('/user/login', [])
            ->assertSeeText("username or password are required");
        ;
    }

    // berhasil login
    public function test_success_login()
    {
        $this->post('/user/login', [
            "user" => "Hanif",
            "password" => "rahasiabro"
        ])
            ->assertRedirect('/')
            ->assertSessionHas("user", "Hanif")
        ;
    }

    // gagal login
    public function test_failed_login()
    {
        $this->post('/user/login/', [
            "user" => "Hanif",
            "password" => "jos"
        ])
            ->assertSeeText("username or password wrong");
        ;
    }

    public function test_dologout_nosession(){
        $this->withSession([
            // "user"=>"Hanif"
        ])
            ->post('/user/logout')
            ->assertRedirect('/user/login')
        ;   
    }

    public function test_logout()
    {
        $this->withSession([
            "user" => "Hanif"
        ])
            ->post('/user/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('user')
        ;
    }


}
