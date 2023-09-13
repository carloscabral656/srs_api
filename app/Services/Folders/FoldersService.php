<?php

namespace App\Services\Folders;

use App\Models\Folders;
use App\Services\ServiceAbstract;

class FoldersService extends ServiceAbstract
{
    public function __construct(Folders $folders)
    {
        parent::__construct($folders);
    }
}
