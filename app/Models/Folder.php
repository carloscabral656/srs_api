<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folders extends Model
{
    use HasFactory;

    protected $table = "folders";
    protected $fillable  = ["title", "description", "id_user", "image"];
}
