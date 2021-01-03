<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\Models\Transaksi;
use App\Models\User;

class UserController extends Controller
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
                            'harga' => (int) env('HARGA_HIGHGAMER'),
                            'status' => 1,
                        );

        $user = User::create($input_user);
        Transaksi::create($input_transaksi);
        return $user;
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        
        if($request->bulan)
        {
            $expired = $user->expired_date > Carbon::now() ? Carbon::parse($user->expired_date) : Carbon::now();
            
            $input_transaksi = array(
                                    'hwid' => $user->hwid, 
                                    'username' => Session::get('username'), //hardcode
                                    'via' => $request->via,
                                    'atas_nama' => $request->atas_nama,
                                    'extend' => $request->bulan,
                                    'harga' => (int) env('HARGA_HIGHGAMER')*$request->bulan,
                                    'status' => 1,
                                );
            
            $update_user  = array(
                'expired_date' => $expired->addMonths($request->bulan),
            );

            Transaksi::create($input_transaksi);
        }
        elseif($request->hwid)
        {
            $update_user = array(
                'hwid' => $request->hwid, 
                'owner' => $request->owner, 
                'server' => $request->server_ao, 
                'keterangan' => $request->keterangan, 
                'expired_date' => $request->expired_date,
            );
        }
        else
        {
            $update_user  = array(
                'status' => $request->status,
            );
        }
        
        $user->update($update_user);
        
        return $user;
    }
}
