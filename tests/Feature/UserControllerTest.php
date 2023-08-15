<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->get("/login")
            ->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "khannedy",
            "password" => "rahasia"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "khannedy");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->post("/login", [
            "user" => "khannedy",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("User Atau Password Tidak Boleh Kosong!");
    }

    public function testLoginFailed()
    {
        $this->post("/login", [
            "user" => "dicky",
            "password" => "salah"
        ])->assertSeeText("User Atau Password Salah!");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->post("/logout")
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post("/logout")
            ->assertRedirect("/");
    }
}
