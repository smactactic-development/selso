<?php

namespace Smactactic\Selso\Extensions;

use Smactactic\Selso\Guards\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class SelsoUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        $userData = session('selso');
        if (!$userData || $userData['id'] != $identifier) {
            return null;
        }

        return new User($userData);
    }

    public function retrieveByToken($identifier, $token) {}
    public function updateRememberToken(Authenticatable $user, $token) {}
    public function retrieveByCredentials(array $credentials) {}
    public function validateCredentials(Authenticatable $user, array $credentials) {}
    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false) {}
}
