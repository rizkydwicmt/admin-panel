<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\Models\TransaksiVBAC;
use App\Models\BotVBAC;

class VBACController extends Controller
{
    public function create(Request $request)
    {
        $input_user = array(
                            'hwid' => $request->hwid, 
                            'owner' => $request->owner, 
                            'server' => $request->server_ao, 
                            'keterangan' => $request->keterangan, 
                            'expired_date' => Carbon::now('Asia/Jakarta')->addMonths($request->bulan), 
                            'created_by' => Session::get('username'), //hardcode
                            'status' => 1,
                        );

        $input_transaksi = array(
                            'hwid' => $request->hwid, 
                            'username' => Session::get('username'), //hardcode
                            'via' => $request->via,
                            'atas_nama' => $request->atas_nama,
                            'extend' => $request->bulan,
                            'harga' => (int) env('HARGA_HIGHGAMER',0),
                            'status' => 1,
                        );

        $user = User::create($input_user);
        Transaksi::create($input_transaksi);
        return $user;
    }
}
