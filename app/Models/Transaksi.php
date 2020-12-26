<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $guarded =  ['id', 'created_at', 'update_at'];

}
