<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findUserByEmailAndPassword($email, $password)
    {
        return User::query()->where('email', $email)->where('password', $password)->get()->first();
    }

    public function createUser(mixed $email, string $password)
    {
        $user = new User();
        $user->email = $email;
        $user->password = $password;
        $isCreated = $user->save();

        if(!$isCreated)
        {
            return null;
        }

        return $user;
    }
}
