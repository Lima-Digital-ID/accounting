<?php

use App\Http\Controllers\v1\DashboardController;
use App\Http\Controllers\v1\UsersController;
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
Route::get('lupa-password-email', [UsersController::class, 'forgotPasswordEmail'])->name('lupa_password_email');
Route::put('lupa-password-email', [UsersController::class, 'forgotPasswordEmailProcess'])->name('lupa_password_email_process');
Route::get('lupa-password/{email}', [UsersController::class, 'forgotPassword'])->name('lupa_password_page');
Route::post('lupa-password', [UsersController::class, 'forgotPasswordProcess'])->name('lupa_password');

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    // dashboard
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    // users trash
    Route::get('/user/trash',[UsersController::class,'trashUser'])->name('user.trash');
    Route::get('/user/restore/{id}',[UsersController::class,'restoreUser'])->name('user.restore');
    Route::get('/user/hapus/{id}',[UsersController::class,'hapusPermanen'])->name('user.hapusPermanen');
    // Users Management
    Route::resource('/user', UsersController::class);
    // change password
    Route::get('change-password', [UsersController::class, 'changePassword'])->name('change_password');
    Route::put('change-password/{id}', [UsersController::class, 'updatePassword'])->name('update_password');
});

require __DIR__.'/auth.php';
