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
            ->assertSeeText('Login');
    }

    public function testLoginWithEmptyUserAndPassword()
    {
        $this->post('/login', ['user' => '', 'password' => ''])
            ->assertSeeText('User and password are required');
    }

    public function testLoginWithInvalidUserAndPassword()
    {
        $this->post('/login', ['user' => 'Invalid', 'password' => 'Invalid'])
            ->assertSeeText('Invalid user or password');
    }

    public function testLoginWithValidUserAndPassword()
    {
        $this->post('/login', ['user' => 'Admin', 'password' => 'password1'])
            ->assertRedirect('/')
            ->assertSessionHas('user', 'Admin');
    }

    public function testLogout()
    {
        $this->withSession(['user' => 'Admin'])
            ->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('user');
    }

    public function testRedirectToHomeIfAlreadyLoggedIn()
    {
        $this->withSession(['user' => 'Admin'])
            ->get('/login')
            ->assertRedirect('/');
    }

    public function testRedirectToHomeIfAlreadyLoggedInOnLogin()
    {
        $this->withSession(['user' => 'Admin'])
            ->post('/login', ['user' => 'Admin', 'password' => 'password1'])
            ->assertRedirect('/');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/login');
    }
}
