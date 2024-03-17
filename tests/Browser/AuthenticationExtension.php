<?php

namespace Tests\Browser;

trait AuthenticationExtension
{
    public function loginAs(string $username, string $password): self
    {
        return $this
            ->visit('/login')
            ->fillField('username', $username)
            ->fillField('password', $password)
            ->click('Sign in');
    }

    public function logout(): self
    {
        return $this->visit('/logout');
    }

    public function assertLoggedIn(): self
    {
        $this->assertSee('Logout');

        return $this;
    }

    public function assertLoggedInAs(string $user): self
    {
        $this->assertSee($user);

        return $this;
    }

    public function assertNotLoggedIn(): self
    {
        $this->assertSee('Login');

        return $this;
    }
}
