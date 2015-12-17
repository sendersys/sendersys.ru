<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Black_list extends Model
{
    protected $table = 'black_list';
    protected $fillable = ['email', 'reason'];
}
