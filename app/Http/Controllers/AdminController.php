<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 

use App\Models\User;
use App\Models\Transaksi;

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
            'pendaftar' => []
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

    public function list_transaksi()
    {
        $transaksi = array(
                            'transaksi' => Transaksi::orderBy('created_at', 'DESC')->get() 
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
}
