<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    protected $table = 'subscribers';
    protected $fillable = ['surname', 'name', 'sex', 'age', 'city', 'email', 'segment_id', 'status_id'];

    public function subscriber_segment()
    {
        return $this->belongsTo('App\Models\Segment', 'segment_id');
    }
}
