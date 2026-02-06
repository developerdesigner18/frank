<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\VisitController;
use App\Http\Controllers\User\CompanyController;
use App\Http\Controllers\User\BranchController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/', function () {

    return redirect()->route('login');
});

Route::group(['middleware' => ['guest:web']], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login-check', 'loginCheck')->name('login-check');
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

Route::group(['middleware' => ['auth:web']], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout')->name('logout');
        Route::post('/update-name', 'updateName')->name('update-name');
        Route::post('/update-password', 'updatePassword')->name('update-password');

    });

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');

    });
    Route::controller(SettingController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings');
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile-update', 'profileUpdate')->name('profile-update');
        Route::get('/change-password', 'changePassword')->name('change-password');

        Route::get('/activity-log', 'activityLog')->name('activity-log');
        Route::get('/contact-support', 'contactSupport')->name('contact-support');
        Route::get('/contact-support/frequently-asked-questions', 'faq')->name('contact-support.faq');
        Route::post('/contact-support/frequently-asked-questions/action', 'faqAction')->name('contact-support.faq.action');
    });


    Route::controller(CompanyController::class)->prefix('company')->group(function () {
        Route::get('/', 'index')->name('company');
        Route::post('/list', 'companyList')->name('company.list');
    });

    Route::controller(BranchController::class)->prefix('company/{companyId}/branches')->name('company.branches.')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(BranchController::class)->prefix('company/branch/{branchId}/visit')->name('company.branch.visits.')->group(function () {
        Route::get('/', 'branchVisits')->name('index');
        Route::post('/list', 'branchVisitsList')->name('list');
    });

    Route::controller(VisitController::class)->prefix('visit')->name('visit.')->group(function () {
        Route::get('/{page}', 'index')->name('index');
        Route::post('/list/{page}', 'list')->name('list');
        Route::post('/completed-list/{page}', 'completedList')->name('completed.list');
        Route::get('/report/{reportId}', 'submissions')->name('submissions');
        Route::get('/report/{reportId}/section/{categoryId}', 'visitCategory')->name('category.section');

        Route::get('/survey/{visit_id}', 'survey')->name('survey');
        Route::post('/questionnaire-update/{id}', 'questionnaireUpdate')->name('questionnaire.update');
        Route::post('/questionnaire-submit', 'questionnaireSubmit')->name('questionnaire.submit');
        Route::post('questionnaire-response-delete-comment-image', 'deleteCommentImage')->name('response.delete.comment.image');
        Route::post('questionnaire-response-comment-image', 'commentImage')->name('response.comment.image');

        Route::get('/generate-pdf/{visit_id}', 'generatePDF')->name('generate.pdf');
        Route::post('/visit/assign/{visit}', [VisitController::class, 'assignVisitor'])->name('visit.assign');

//        Available
        Route::get('/available', 'availableVisits')->name('available');
        Route::post('/available-list', 'availableList')->name('available.list');
        Route::post('/available-list-filter', 'availableListFilter')->name('available.list.filter');
        Route::post('/request', 'request')->name('request');

    });

});

require __DIR__ . '/common.php';
