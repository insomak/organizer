<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Yaml\Yaml;
use App\Security\YamlUser;

class YamlUserProvider implements UserProviderInterface
{
    private array $users;

    public function __construct()
    {
        $this->users = Yaml::parseFile(__DIR__ . '/../../config/users.yaml')['users'] ?? [];
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        foreach ($this->users as $username => $data) {
            if ($username === $identifier || $data['email'] === $identifier) {
                return new YamlUser($username, $data['email'], $data['password'], $data['roles']);
            }
        }

        throw new UserNotFoundException("Użytkownik '{$identifier}' nie został znaleziony.");
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === YamlUser::class;
    }
}
