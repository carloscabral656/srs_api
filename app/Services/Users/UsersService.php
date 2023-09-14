<?php

namespace App\Services\Users;

use App\Models\User;
use App\Services\ServiceAbstract;

class UsersService extends ServiceAbstract
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function store(array $data)
    {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $age = (isset($data['age']) and is_null($data['age'])) ?: null;
        $user = $this->model->create([
            'name' => $name,
            'password' => $password,
            'email' => $email
        ]);
        $roles = $data['roles'];
        $user->roles()->sync($roles);
        return $user;
    }
}
