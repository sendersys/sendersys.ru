<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_site2content extends Model
{
    protected $table = 'users_site2content';
    protected $fillable = ['domen_id', 'category_id', 'type_id'];
}
