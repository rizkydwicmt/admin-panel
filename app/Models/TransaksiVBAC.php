<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TransaksiVBAC extends Model
{
    protected $table = 'transaksi_vbac';

    protected $guarded =  ['id', 'created_at', 'update_at'];

}
