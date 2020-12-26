<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserDetail extends Model
{
    protected $table = 'user_detail';

    protected $guarded =  ['id', 'created_at', 'update_at'];

}
