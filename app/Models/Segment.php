<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    protected $table = 'segment';
    protected $fillable = ['segment_name', 'domen_id'];

    public function user_sites()
    {
        return $this->belongsTo('App\Models\Users_site', 'domen_id');
    }

    public function subscribers()
    {
        return $this->hasMany('App\Models\Subscribers');
    }
}
