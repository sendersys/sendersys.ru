<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    protected $table = 'segment';
    protected $fillable = ['segment_name', 'domen_id'];
}
