<?php

namespace App\Services\Groups;

use App\Models\Group;
use App\Services\ServiceAbstract;

class GroupsService extends ServiceAbstract
{
    public function __construct(Group $group)
    {
        parent::__construct($group);
    }
}
