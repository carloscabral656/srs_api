<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = "groups";
    protected $fillable = ["title", "description"];

    public function users(){
        return $this->belongsToMany(User::class, 'user_group', 'id_group', 'id_user');
    }
}
