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
Route::get('/login', function () {
    return view('welcome');
});

/* Admin */

$router->group(['prefix' => 'akses_admin'], function () use ($router) {
    /* Admin Login */
    Route::get('/login', 'AuthController@login');
    Route::post('/login', 'AuthController@cek_login');
    Route::get('/logout', 'AuthController@logout');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        /* Highgamer */
        Route::get('/', 'AdminController@dashboard');
        Route::get('/list_user', 'AdminController@list_user');
        Route::get('/kelola_user', 'AdminController@kelola_user');
        Route::get('/list_transaksi', 'AdminController@list_transaksi');
        Route::get('/kelola_transaksi', 'AdminController@kelola_transaksi');
        Route::get('/list_bot', 'AdminController@list_bot');

        /* VBAC */
        Route::get('/vbac/kelola_bot', 'AdminController@kelola_bot_vbac');
        Route::get('/vbac/kelola_transaksi', 'AdminController@kelola_transaksi_vbac');
        
        Route::post('/change_password', 'AdminController@update');
    });
});


/* Users */
Route::post('add_users', 'UserController@create');
Route::post('update_users', 'UserController@update');

/* Transaksi */
Route::post('update_transaksi', 'transaksiController@update');

/* Bot VBAC */
Route::post('/vbac/add_bot', 'transaksiController@create');
Route::post('/vbac/update_bot', 'transaksiController@update');

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