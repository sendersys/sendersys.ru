<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Main_page extends Model
{
    protected $table = 'main_page';
    protected $fillable = [
        'first_string',
        'second_string',
        'content_title',
        'first_column_title',
        'first_column_text',
        'second_column_title',
        'second_column_text',
        'first_footer_string',
        'active',
    ];

    public function getActiveStringAttribute()
    {
        return ($this->active == 1) ? 'Активно' : 'Неактивно';
    }
}
