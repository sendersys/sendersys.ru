<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber_link extends Model
{
    protected $table = 'subscriber_links';
    protected $fillable = ['subscriber_id', 'redirect_link', 'campaign_id', 'link_hash'];
}
