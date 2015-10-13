<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailing_list extends Model
{
    protected $table = 'mailing_list';
    protected $fillable = ['name', 'domen_id', 'type_id', 'return_address', 'date_start', 'time_start'];

    public function segment()
    {
        return $this->hasMany('App\Models\Mailing_list2segment', 'mailing_id', 'id');
    }

    public function period()
    {
        return $this->hasMany('App\Models\Mailing_list2period', 'mailing_id', 'id');
    }

}