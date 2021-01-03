<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Admin;

class AuthController extends Controller
{

    public function login()
    {
        return view('konten/login');
    }

    public function cek_login(Request $request)
    {
        $salt = 'aobot';
        $where = array( 
            'username' => $request->username, 
            'password' => sha1($request->password.$salt), 
        );

        $query = Admin::where($where)->first();
        
        if(isset($query->username)){
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
