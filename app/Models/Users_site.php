<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_site extends Model
{
    protected $table = 'users_site';
    protected $fillable = ['domen', 'user_id', 'visitor', 'base_size'];
}
