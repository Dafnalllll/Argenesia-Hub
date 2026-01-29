<?php

use App\Livewire\Auth\Login;
use App\Http\Middleware\role;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard\Cuti;
use App\Livewire\Admin\RekapCuti;
use App\Livewire\Dashboard\Profil;
use App\Livewire\Admin\AturTipeCuti;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\ManajemenCuti;
use App\Livewire\Admin\ManajemenUser;
use App\Livewire\Dashboard\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Cuti\Riwayat;
use App\Livewire\Admin\ManajemenKaryawan;
use App\Livewire\Dashboard\Cuti\Pengajuan;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\HR\Dashboard\Dashboard as HRDashboard;
use App\Livewire\HR\ManajemenCuti\RekapCuti as HRRekapCuti;
use App\Livewire\HR\ManajemenKaryawan\ManajemenKaryawan as HRManajemenKaryawan;
use App\Livewire\HR\ManajemenCuti\ManajemenCuti as HRManajemenCuti;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', Login::class)->name('login');

Route::get('/register', Register::class)->name('register');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profil', Profil::class)->name('profil');
    Route::get('/cuti', Cuti::class)->name('cuti');
    Route::get('/cuti/pengajuan', Pengajuan::class)->name('cuti.pengajuan');
    Route::get('/cuti/riwayat', Riwayat::class)->name('cuti.riwayat');
    Route::get('/cuti/download-template', function () {
        return response()->download(public_path('files/template_surat_cuti_argenesia.docx'));
    })->name('cuti.download-template');

    // Route khusus admin
    Route::middleware([role::class . ':Admin'])->group(function () {
        Route::get('/dashboard/admin', AdminDashboard::class)->name('dashboard.admin');
        Route::get('/admin/manajemen-user', ManajemenUser::class)->name('manajemen-user');
        Route::get('/admin/manajemen-karyawan', ManajemenKaryawan::class)->name('manajemen-karyawan');
        Route::get('/admin/manajemen-cuti',ManajemenCuti::class)->name('manajemen-cuti');
        Route::get('/admin/manajemen-cuti/atur-tipe-cuti',AturTipeCuti::class)->name('atur-tipe-cuti');
        Route::get('/admin/manajemen-cuti/rekap-cuti',RekapCuti::class)->name('rekap-cuti');

    });

    Route::middleware([role::class . ':HR'])->group(function () {
        Route::get('/dashboard/hr', HRDashboard::class)->name('dashboard.hr');
        Route::get('/hr/manajemen-karyawan', HRManajemenKaryawan::class)->name('hr.manajemen-karyawan');
        Route::get('/hr/manajemen-cuti/rekap-cuti', HRRekapCuti::class)->name('hr.manajemen-cuti.rekap-cuti');
        Route::get('/hr/manajemen-cuti', HRManajemenCuti::class)->name('hr.manajemen-cuti');
    });
});



// Route fallback untuk halaman tidak ditemukan
Route::fallback(function () {
    return response()->view('notfound', [], 404);
});


