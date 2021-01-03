<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

use App\Models\Admin;

class AuthController extends Controller
{

    public function login()
    {
        return view('konten/login');
    }

    public function cek_login(Request $request)
    {
        $where = array( 
            'username' => $request->username,
        );

        $query = Admin::where($where)->first();
        
        if(Hash::check($request->password.env('SALT'), $query->password)){
            Session::put('username',$query->username);
            return redirect('akses_admin');
        }else{
            return redirect('akses_admin/login')->with('alert-danger','Username atau password salah');
        }
    }

    public function logout(){
        Session::flush();
        return redirect('akses_admin/login')->with('alert-primary','Anda berhasil logout');
    }


}
