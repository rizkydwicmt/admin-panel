<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function update(Request $request)
    {
        $transaksi = Transaksi::find($request->id)->update($request->all());
    
        return $transaksi;
    }
}
