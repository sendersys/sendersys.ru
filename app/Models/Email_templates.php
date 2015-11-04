<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email_templates extends Model
{
    protected $table = 'email_templates';
    protected $fillable = ['domen_id', 'user_id', 'properties'];
}
