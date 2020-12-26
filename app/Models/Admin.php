<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Admin extends Model
{
    protected $table = 'admin';

    protected $guarded =  ['id', 'created_at', 'update_at'];

}
