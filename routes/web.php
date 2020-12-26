<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* Users */

// Route::get('/', 'UsersController@home');
// Route::get('Tanggal', 'UsersController@get_tanggal');
// Route::get('Ketersediaan', 'UsersController@get_ketersediaan');
// Route::post('Confirmation', 'UsersController@create');
// Route::post('Update_Users', 'UsersController@update');
// Route::post('Send_notif', 'UsersController@send');

/* Admin */

/* Admin Login */
// Route::get('Akses_Admin/Login', 'AuthController@login');
// Route::post('Akses_Admin/Login', 'AuthController@cek_login');
// Route::get('Akses_Admin/Logout', 'AuthController@logout');
/* Admin Dashboard */
// Route::get('Akses_Admin', 'AdminController@dashboard');
// Route::get('Akses_Admin/List_Penjadwalan', 'AdminController@list_penjadwalan');
// Route::get('Akses_Admin/Kelola_Penjadwalan', 'AdminController@kelola_penjadwalan');