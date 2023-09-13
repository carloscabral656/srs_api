<?php

namespace App\Services\Lists;

use App\Models\Lists;
use App\Services\ServiceAbstract;

class ListsService extends ServiceAbstract
{
    public function __construct(Lists $lists)
    {
        parent::__construct($lists);
    }
}
