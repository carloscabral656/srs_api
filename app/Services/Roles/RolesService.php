<?php

namespace App\Services\Roles;

use App\Models\Roles;
use App\Services\ServiceAbstract;

class RolesService extends ServiceAbstract
{
    public function __construct(Roles $roles)
    {
        parent::__construct($roles);
    }
}
