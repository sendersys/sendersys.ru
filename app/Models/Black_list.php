<?php

namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;
//use Illuminate\Database\Eloquent\Model;


class Black_list extends SleepingOwlModel
{
    protected $table = 'black_list';
    protected $fillable = ['email', 'reason'];
}
