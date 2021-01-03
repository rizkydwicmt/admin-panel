<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Transaksi;
use App\Models\BotVBAC;
use App\Models\TransaksiVBAC;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = array(
            'total' => 0,
            'dikonfirmasi' => 0,
            'menunggu' => 0,
            'ditolak' => 0,
            'bulan' => 0,
            'bulan_ini' => 0,
            'persen' => 0,
            'color_bulan' => 0,
            'pendaftar' => [],
            'harga' => (int) env('HARGA_HIGHGAMER',0)
        );

        return view('konten/dashboard', $data);
    }

    public function list_user()
    {
        $users = array('pendaftar' => User::get() );
        return view('konten/list_user', $users);
    }

    public function kelola_user()
    {
        $users = array('pendaftar' =>  User::get() );
        return view('konten/kelola_user', $users);
    }

    public function list_transaksi(Request $request)
    {
        $transaksi = Transaksi::orderBy('created_at', 'DESC');

        if($request->bulan)
        {
            $date = explode("-", $request->bulan);
            $transaksi->whereMonth('created_at', '=', $date[1])
            ->whereYear('created_at', '=', $date[0]);
        }

        $transaksi = array(
            'transaksi' => $transaksi->get() 
        );

        return view('konten/list_transaksi', $transaksi);
    }

    public function kelola_transaksi()
    {
        $transaksi = array(
                            'pendaftar' =>  User::get(),
                            'transaksi' =>  Transaksi::orderBy('created_at', 'DESC')->get() 
                        );
        return view('konten/kelola_transaksi', $transaksi);
    }

    public function list_bot()
    {
        $bot = array(
                    'bot' => UserDetail::get() 
                );
        return view('konten/list_bot', $bot);
    }

    public function kelola_bot_vbac()
    {
        $bot = array(
                    'bot' => BotVBAC::get() 
                );
        return view('konten/vbac/kelola_bot', $bot);
    }
}
