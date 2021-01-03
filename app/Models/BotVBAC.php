<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BotVBAC extends Model
{
    protected $table = 'bot_vbac';

    protected $guarded =  ['id', 'created_at', 'update_at'];

}
