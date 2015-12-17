<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_site extends Model
{
    protected $table = 'users_site';
    protected $fillable = ['domen', 'user_id', 'visitor', 'confirm', 'confirm_hash', 'base_size'];

    public function segments()
    {
        return $this->hasMany('App\Models\Segment', 'domen_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
