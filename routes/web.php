<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArsipController;
use App\Http\Controllers\Admin\DisposisiController;
use App\Http\Controllers\Admin\IncomingController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\OutgoingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Incoming;
use App\Models\Outgoing;

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

Route::get('/storage-link', function () {
    $targetFolder = base_path() . '/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});

Route::get('/clear-cache', function () {
    Artisan::call('route:cache');
});

Route::get('/', [LoginController::class, 'index']);

// Authentication
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login-action', [LoginController::class, 'login_action']);
Route::post('/logout', [LoginController::class, 'logout']);

//Admin
Route::prefix('admin')->middleware('authAdmin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');
    
    //surat-masuk
    Route::get('/surat-masuk', [IncomingController::class, 'incoming_mail'])->name('surat-masuk');
    Route::get('/surat-masuk/create', [IncomingController::class, 'incoming_create'])->name('surat-masuk-create');
    Route::post('/surat-masuk/store', [IncomingController::class, 'incoming_store'])->name('surat-masuk-store');
    Route::get('/surat-masuk/{id}/edit', [IncomingController::class, 'edit_incoming'])->name('letter.edit_incoming');
    Route::put('/surat-masuk/{id}/update', [IncomingController::class, 'update_incoming'])->name('letter.update_incoming');
    Route::get('/surat-masuk/{id}/show', [IncomingController::class, 'show_incoming'])->name('letter.show_incoming');
    Route::delete('/surat-masuk/{id}/destroy', [IncomingController::class, 'destroy_incoming'])->name('letter.destroy_incoming');
    Route::get('/surat-masuk/{id}/approve', [IncomingController::class, 'approve'])->name('approve');
    Route::get('/surat-masuk/{id}/reject', [IncomingController::class, 'reject'])->name('reject');
    Route::get('/surat-masuk/download/{id}', [IncomingController::class, 'download_surat_masuk'])->name('download-surat-masuk-admin');
    Route::post('surat-masuk/{id}/teruskan', [IncomingController::class, 'teruskan_disposisi']);
    Route::get('surat-masuk/{id}/arsipkan', [DisposisiController::class, 'arsipkan']);
    //surat-keluar
    Route::get('/surat-keluar', [OutgoingController::class, 'outgoing_mail'])->name('surat-keluar');
    Route::get('/surat-keluar/create', [OutgoingController::class, 'outgoing_create'])->name('surat-keluar-create');
    Route::post('/surat-keluar/store', [OutgoingController::class, 'outgoing_store'])->name('surat-keluar-store');
    Route::get('/surat-keluar/{id}/edit', [OutgoingController::class, 'edit_outgoing'])->name('letter.edit_outgoing');
    Route::put('/surat-keluar/{id}/update', [OutgoingController::class, 'update_outgoing'])->name('letter.update_outgoing');
    Route::get('/surat-keluar/{id}/show', [OutgoingController::class, 'show_outgoing'])->name('letter.show_outgoing');
    Route::delete('/surat-keluar/{id}/destroy', [OutgoingController::class, 'destroy_outgoing'])->name('letter.destroy_outgoing');
    Route::get('/surat-keluar/{id}/approve', [OutgoingController::class, 'approve'])->name('approve');
    Route::get('/surat-keluar/{id}/reject', [OutgoingController::class, 'reject'])->name('reject');
    Route::get('/surat-keluar/download/{id}', [OutgoingController::class, 'download_surat_keluar'])->name('download-surat-keluar-admin');
    Route::get('surat-keluar/{id}/arsipkan', [OutgoingController::class, 'arsipkan']);

    Route::resource('/disposisi', DisposisiController::class);

    //print
    Route::get('/print/surat-masuk', [PrintController::class, 'index']);
    Route::get('/print/surat-keluar', [PrintController::class, 'outgoing'])->name('print-surat-keluar');
    //arsip
    Route::get('/arsip', [ArsipController::class, 'index']);
    //user
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::get('/user/{id}/edit', [UserController::class, 'edit']);
    Route::put('/user/{id}/update', [UserController::class, 'update']);
    Route::delete('/user/{id}/destroy', [UserController::class, 'destroy']);

    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('setting', [SettingController::class, 'index']);
    Route::put('/setting/update/{id}', [SettingController::class, 'update'])->name('update-profile');
    Route::get('/setting/password', [SettingController::class, 'change_password'])->name('change-password');
    Route::post('/setting/upload-profile', [SettingController::class, 'upload_profile'])->name('profile-upload');
    Route::post('/change-password', [SettingController::class, 'update_password'])->name('update.password');
});

//Kepala Sekolah
Route::prefix('kepsek')->middleware('authKepsek')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('kepala-sekolah-dashboard');
    
    //surat-masuk
    Route::get('surat-masuk', [IncomingController::class, 'incoming_mail'])->name('surat-masuk');
    Route::get('surat-masuk/{id}/show', [IncomingController::class, 'show_incoming'])->name('letter.show_incoming');
    Route::put('surat-masuk/{id}/disposisikan', [IncomingController::class, 'disposisi']);
    Route::put('surat-masuk/{id}/tolak_disposisi', [IncomingController::class, 'tolakDisposisi']);
    Route::get('/surat-masuk/download/{id}', [IncomingController::class, 'download_surat_masuk'])->name('download-surat-masuk-kepsek');
    Route::get('surat-keluar', [OutgoingController::class, 'outgoing_mail'])->name('surat-keluar');
    Route::get('surat-keluar/{id}/show', [OutgoingController::class, 'show_outgoing'])->name('letter.show_outgoing');
    Route::put('surat-keluar/{id}/kirim_surat', [OutgoingController::class, 'kirimSurat']);
    Route::put('surat-keluar/{id}/tolak_surat', [OutgoingController::class, 'tolakSurat']);
    Route::get('/surat-keluar/download/{id}', [OutgoingController::class, 'download_surat_keluar'])->name('download-surat-keluar-kepsek');

    //print
    Route::get('print/surat-masuk', [PrintController::class, 'index']);
    Route::get('print/surat-keluar', [PrintController::class, 'outgoing'])->name('print-surat-keluar');
    //arsip
    Route::get('/arsip', [ArsipController::class, 'index']);
    //user
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::get('/user/{id}/edit', [UserController::class, 'edit']);
    Route::put('/user/{id}/update', [UserController::class, 'update']);
    Route::delete('/user/{id}/destroy', [UserController::class, 'destroy']);
    // Route::resource('setting', SettingController::class, [
    //     'except' => ['show']
    // ]);
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('setting', [SettingController::class, 'index']);
    Route::put('/setting/update/{id}', [SettingController::class, 'update'])->name('update-profile');
    Route::get('setting/password', [SettingController::class, 'change_password'])->name('change-password');
    Route::post('setting/upload-profile', [SettingController::class, 'upload_profile'])->name('profile-upload');
    Route::post('change-password', [SettingController::class, 'update_password'])->name('update.password');
});


//Guru
Route::prefix('guru')->middleware('authGuru')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('guru-dashboard');
     //surat-masuk
     Route::get('surat-masuk', [IncomingController::class, 'incoming_mail'])->name('surat-masuk');
     Route::get('surat-masuk/{id}/show', [IncomingController::class, 'show_incoming'])->name('letter.show_incoming');
     Route::get('surat-masuk/download/{id}', [IncomingController::class, 'download_surat_masuk'])->name('download-surat-masuk-guru');
     Route::put('surat-masuk/{id}/terima_berkas', [IncomingController::class, 'terima_berkas']);
     //surat-keluar
     Route::get('surat-keluar', [OutgoingController::class, 'outgoing_mail'])->name('surat-keluar');
     Route::get('surat-keluar/{id}/show', [OutgoingController::class, 'show_outgoing'])->name('letter.show_outgoing');
     Route::get('/surat-keluar/download/{id}', [OutgoingController::class, 'download_surat_keluar'])->name('download-surat-keluar-guru');
   
    //print
    Route::get('print/surat-masuk', [PrintController::class, 'index']);
    Route::get('print/surat-keluar', [PrintController::class, 'outgoing'])->name('print-surat-keluar');
    //arsip
    Route::get('/arsip', [ArsipController::class, 'index']);
    //user
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::get('/user/{id}/edit', [UserController::class, 'edit']);
    Route::put('/user/{id}/update', [UserController::class, 'update']);
    Route::delete('/user/{id}/destroy', [UserController::class, 'destroy']);
    // Route::resource('setting', SettingController::class, [
    //     'except' => ['show']
    // ]);
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('setting', [SettingController::class, 'index']);
    Route::put('/setting/update/{id}', [SettingController::class, 'update'])->name('update-profile');
    Route::get('setting/password', [SettingController::class, 'change_password'])->name('change-password');
    Route::post('setting/upload-profile', [SettingController::class, 'upload_profile'])->name('profile-upload');
    Route::post('change-password', [SettingController::class, 'update_password'])->name('update.password');
});


//staff
Route::prefix('staff')->middleware('authStaff')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('staff-dashboard');
    
    //surat-masuk
    Route::get('surat-masuk', [IncomingController::class, 'incoming_mail'])->name('surat-masuk');
    Route::get('surat-masuk/create', [IncomingController::class, 'incoming_create'])->name('surat-masuk-create');
    Route::post('surat-masuk/store', [IncomingController::class, 'incoming_store'])->name('surat-masuk-store');
    Route::get('surat-masuk/{id}/edit', [IncomingController::class, 'edit_incoming'])->name('letter.edit_incoming');
    Route::put('surat-masuk/{id}/update', [IncomingController::class, 'update_incoming'])->name('letter.update_incoming');
    Route::get('surat-masuk/{id}/show', [IncomingController::class, 'show_incoming'])->name('letter.show_incoming');
    Route::delete('surat-masuk/{id}/destroy', [IncomingController::class, 'destroy_incoming'])->name('letter.destroy_incoming');
    Route::get('surat-masuk/download/{id}', [IncomingController::class, 'download_surat_masuk'])->name('download-surat-masuk-staff');

    //surat-keluar
    Route::get('surat-keluar', [OutgoingController::class, 'outgoing_mail'])->name('surat-keluar');
    Route::get('surat-keluar/create', [OutgoingController::class, 'outgoing_create'])->name('surat-keluar-create');
    Route::post('surat-keluar/store', [OutgoingController::class, 'outgoing_store'])->name('surat-keluar-store');
    Route::get('surat-keluar/{id}/edit', [OutgoingController::class, 'edit_outgoing'])->name('letter.edit_outgoing');
    Route::put('surat-keluar/{id}/update', [OutgoingController::class, 'update_outgoing'])->name('letter.update_outgoing');
    Route::get('surat-keluar/{id}/show', [OutgoingController::class, 'show_outgoing'])->name('letter.show_outgoing');
    Route::delete('surat-keluar/{id}/destroy', [OutgoingController::class, 'destroy_outgoing'])->name('letter.destroy_outgoing');
    Route::get('surat-keluar/download/{id}', [OutgoingController::class, 'download_surat_keluar'])->name('download-surat-keluar-staff');

    //print
    Route::get('print/surat-masuk', [PrintController::class, 'index'])->name('print-surat-masuk');
    Route::get('print/surat-keluar', [PrintController::class, 'outgoing'])->name('print-surat-keluar');
    //arsip
    Route::get('/arsip', [ArsipController::class, 'index']);
    //user
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::get('/user/{id}/edit', [UserController::class, 'edit']);
    Route::put('/user/{id}/update', [UserController::class, 'update']);
    Route::delete('/user/{id}/destroy', [UserController::class, 'destroy']);
    // Route::resource('setting', SettingController::class, [
    //     'except' => ['show']
    // ]);
    Route::get('setting', [SettingController::class, 'index']);
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::put('/setting/update/{id}', [SettingController::class, 'update'])->name('update-profile');
    Route::get('setting/password', [SettingController::class, 'change_password'])->name('change-password');
    Route::post('setting/upload-profile', [SettingController::class, 'upload_profile'])->name('profile-upload');
    Route::post('change-password', [SettingController::class, 'update_password'])->name('update.password');
});
