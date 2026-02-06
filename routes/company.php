<?php
use App\Http\Controllers\Company\AuthController;
use App\Http\Controllers\Company\BranchController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'guest:company'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login-check', 'loginAction')->name('login-check');
        Route::post('/register', 'register')->name('register');
        Route::get('/check-invitation/{cryptToken}', 'checkInvitation')->name('check-invitation');
    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'showForgetPasswordForm')->name('forget.password.get');
        Route::get('mail-sent', 'showSuccessPageForm')->name('mail.sent.get');
        Route::post('forget-password', 'submitForgetPasswordForm')->name('forget.password.post');
        Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');
        Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');
    });
});

Route::group(['middleware' => 'auth:company'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout')->name('logout');
        Route::post('/switch-profile', 'switchProfile')->name('switch.profile');
        Route::post('/update-name', 'updateName')->name('update-name');
        Route::post('/update-password', 'updatePassword')->name('update-password');
    });

    Route::controller(BranchController::class)->group(function () {
        Route::get('/branch', 'index')->name('branch');
        Route::post('branches/list', 'listBranch')->name('branches.list');
        Route::get('branches/visits/{id}', 'branchVisits')->name('branches.visits');
        Route::post('branches/visits/list/{id}', 'branchVisitsList')->name('branches.visits.list');
        Route::get('branches/visit/generate-pdf/{visit_id}', 'generatePDF')->name('branches.visit.generate.pdf');
    });
});

require __DIR__ . '/common.php';
