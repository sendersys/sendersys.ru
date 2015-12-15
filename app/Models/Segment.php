<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Models\SleepingOwlModel;

class Segment extends SleepingOwlModel
{
    protected $table = 'segment';
    protected $fillable = ['segment_name', 'domen_id'];

    public function user_sites()
    {
        return $this->belongsTo('App\Models\Users_site');
    }
}
