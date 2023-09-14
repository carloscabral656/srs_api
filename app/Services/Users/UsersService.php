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
}
