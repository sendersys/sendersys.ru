<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Models\SleepingOwlModel;

class Users_site extends SleepingOwlModel
{
    protected $table = 'users_site';
    protected $fillable = ['domen', 'user_id', 'visitor', 'confirm', 'confirm_hash', 'base_size'];

//    public function segment()
//    {
//        return $this->hasMany('App\Models\Segment');
//    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
