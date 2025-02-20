<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class YamlUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    private string $username;
    private string $email;
    private string $password;
    private array $roles;

    public function __construct(string $username, string $email, string $password, array $roles)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function eraseCredentials(): void {}

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
