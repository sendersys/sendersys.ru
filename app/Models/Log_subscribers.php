<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log_subscribers extends Model
{
    protected $table = 'log_subscribers';
    protected $fillable = ['subscriber_id', 'segment_id', 'action', 'params'];
}
