<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber_status extends Model
{
    protected $table = 'subscriber_status';
    protected $fillable = ['status_name', 'description'];
}
