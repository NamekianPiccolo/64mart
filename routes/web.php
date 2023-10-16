<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'login']);
//Logout
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout')->middleware('guest');


Route::middleware(['auth'])->group(function () {
    Route::middleware(['userAkses:admin'])->group(function () {

        // DASHBOARD ADMIN
        Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard.admin');

        // KATEGORI
        Route::resource('/admin/kategori', KategoriController::class)->names([
            'index' => 'admin.kategori.index',
            'store' => 'admin.kategori.store',
            'update' => 'admin.kategori.update',
            'destroy' => 'admin.kategori.destroy',
        ]);

        // PRODUK
        Route::resource('/admin/produk', ProdukController::class)->names([
            'index' => 'admin.produk.index',
            'store' => 'admin.produk.store',
            'update' => 'admin.produk.update',
            'destroy' => 'admin.produk.destroy',
        ]);

        Route::post('/admin/tambah-ke-keranjang', [KeranjangController::class, 'tambahKeKeranjang'])->name('tambahKeKeranjang');
        Route::post('/admin/checkout', [KeranjangController::class, 'checkout'])->name('checkout');
        // TRANSAKSI
        Route::resource('/admin/transaksi', TransaksiController::class)->names([
            'index' => 'admin.transaksi.index',
            'create' => 'admin.transaksi.create',
            'store' => 'admin.transaksi.store',
            'show' => 'admin.transaksi.show',
            'edit' => 'admin.transaksi.edit',
            'update' => 'admin.transaksi.update',
            'destroy' => 'admin.transaksi.destroy',
        ]);


        // USERS
        Route::get('/admin/users/data_admin', [UserController::class, 'adminIndex'])->name('data_admin');
        Route::get('/admin/users/data_kasir', [UserController::class, 'kasirIndex'])->name('data_kasir');
        Route::get('/admin/users/data_owner', [UserController::class, 'ownerIndex'])->name('data_owner');

        Route::delete('/admin/users/data_admin/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::delete('/admin/users/data_owner/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::delete('/admin/users/data_kasir/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::post('/admin/users/data_{role}', [UserController::class, 'store'])->name('users.store')->where('role', 'admin|owner|kasir');
        Route::put('/admin/users/data_admin/{user}', [UserController::class, 'update'])->name('users.update');
        Route::put('/admin/users/data_owner/{user}', [UserController::class, 'update'])->name('users.update');
        Route::put('/admin/users/data_kasir/{user}', [UserController::class, 'update'])->name('users.update');

        // Route::post('/calculateTotalHarga', [TransaksiController::class, 'calculateTotalHarga'])->name('transaksi.calculateTotalHarga');
    });

    Route::middleware(['userAkses:owner'])->group(function () {
        // Route::resource('/owner/kategori', KategoriController::class);
    });

    Route::middleware(['userAkses:kasir'])->group(function () {
        // DASHBOARD KASIR
        Route::get('/kasir', [DashboardController::class, 'index'])->name('dashboard.kasir');

        // KATEGORI
        Route::resource('/kasir/kategori', KategoriController::class)->names([
            'index' => 'kasir.kategori.index',
            'create' => 'kasir.kategori.create',
            'store' => 'kasir.kategori.store',
            'show' => 'kasir.kategori.show',
            'edit' => 'kasir.kategori.edit',
            'update' => 'kasir.kategori.update',
            'destroy' => 'kasir.kategori.destroy',
        ]);
    });
});
