<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignRecipient extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['queued_at'=>'datetime','attempted_at'=>'datetime','sent_at'=>'datetime','retry_at'=>'datetime'];
}
