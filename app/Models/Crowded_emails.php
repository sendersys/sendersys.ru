<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crowded_emails extends Model
{
    protected $table = 'crowded_emails';
    protected $fillable = ['email'];
}
