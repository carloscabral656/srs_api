<?php

namespace App\Services\Groups;

use App\Models\Group;
use App\Services\ServiceAbstract;
use Exception;

class GroupsService extends ServiceAbstract
{
    public function __construct(Group $group)
    {
        parent::__construct($group);
    }

    public function store(array $data){
        try{
            $title = $data['title'];
            $description = $data['description'];
            $users = $data['users'];
            $this->model->store(['title' => $title, 'description' => $description]);
            $this->model->users()->sync($users);
        }catch(Exception $e){
            throw $e;
        }
    }
}
