<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\MysteryVisitorController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\EmailController;
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

//Route::get('/run-mail-publish', function () {
//    Artisan::call('vendor:publish', [
//        '--tag' => 'laravel-mail',
//
//    ]);
//
//    return 'Mail views published';
//});

// Route::get('/lang/{locale}', function ($locale) {
//     if (in_array($locale, ['en', 'nl'])) {
//         session(['locale' => $locale]);
//     }
//     return back();
// })->name('lang.switch');
require __DIR__ . '/common.php';

Route::group(['middleware' => 'guest:admin'], function () {
    
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login-action', 'loginAction')->name('login-action');
    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'showForgetPasswordForm')->name('forget.password.get');
        Route::get('mail-sent', 'showSuccessPageForm')->name('mail.sent.get');
        Route::post('forget-password', 'submitForgetPasswordForm')->name('forget.password.post');
        Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');
        Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');
    });
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });
    
    // Admin Users Management
    Route::controller(\App\Http\Controllers\Admin\AdminUserController::class)->name('admin-users.')->prefix('admin-users')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/list', 'list')->name('list');
        Route::post('/add', 'add')->name('add');
        Route::post('/edit', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::post('/delete', 'delete')->name('delete');
    });
    
    Route::controller(\App\Http\Controllers\Admin\SubdealerController::class)->name('subdealer.')->prefix('subdealer')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/list', 'list')->name('list');
        Route::post('/add', 'add')->name('add');
        Route::post('/edit', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::post('/delete', 'delete')->name('delete');
    });
    Route::controller(CompanyController::class)->prefix('company')->name('company.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/list', 'companyList')->name('list');
        Route::post('/add', 'addCompany')->name('add');
        Route::post('/edit', 'editCompany')->name('edit');
        Route::post('/update', 'updateCompany')->name('update');
        Route::post('/delete', 'deleteCompany')->name('delete');
        Route::post('/status/update', 'updateStatus')->name('update.status');
    });

    Route::controller(CompanyController::class)->prefix('company/users')->name('company.users.')->group(function () {
        Route::post('list', 'listCompanyUsers')->name('list');
        Route::post('add', 'addCompanyUser')->name('add');
        Route::post('edit', 'editCompanyUser')->name('edit');
        Route::post('update', 'updateCompanyUser')->name('update');
        Route::post('update/status', 'updateCompanyUserStatus')->name('update.status');
        Route::post('delete', 'deleteCompanyUser')->name('delete');
        Route::post('/invite', 'inviteUser')->name('invite');
        Route::post('/re-invite', 'reInviteUser')->name('re.invite');
    });

    Route::controller(BranchController::class)->prefix('company/{companyId}/branches')->name('company.branches.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/list', 'branchList')->name('list');

        Route::post('add', 'addBranch')->name('add');
        Route::post('edit', 'editBranch')->name('edit');
        Route::post('update', 'updateBranch')->name('update');
        Route::post('update/status', 'updateBranchStatus')->name('update.status');
        Route::post('delete', 'deleteBranch')->name('delete');
    });

    Route::controller(BranchController::class)->prefix('company/branch/{branchId}')->name('company.branch.')->group(function () {
        Route::get('/visit', 'branchVisits')->name('visits.index');
        Route::post('/visit/list', 'branchVisitsList')->name('visits.list');

        Route::get('/visit-report', 'visitReport')->name('visit.report');
        Route::post('/visit-report-list', 'visitReportList')->name('visit.report.list');
    });

    Route::controller(BranchController::class)->group(function () {
        Route::get('/visit-report/{reportId}', 'visitSubmissions')->name('visit.submissions');
        Route::get('/visit-report/{reportId}/section/{categoryId}', 'visitCategory')->name('visit.category.section');
    });
//    Route::controller(BranchController::class)
//        ->prefix('company/branch/view')
//        ->group(function () {
//            Route::get('/view-submissions', 'visitSubmissions')->name('submissions');
//        });
    Route::controller(BranchController::class)->prefix('company/{companyId}/branch/users')->name('company.branch.users.')->group(function () {
        Route::post('list', 'listBranchContact')->name('list');
        Route::post('add', 'addBranchContact')->name('add');
        Route::post('edit', 'editBranchContact')->name('edit');
        Route::post('update', 'updateBranchContact')->name('update');
        Route::post('update/status', 'updateBranchContactStatus')->name('update.status');
        Route::post('delete', 'deleteBranchContact')->name('delete');
    });

    Route::controller(MysteryVisitorController::class)->prefix('visitor')->name('visitor.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/list', 'listVisitor')->name('list');
        Route::post('/add', 'addVisitor')->name('add');
        Route::post('/invite', 'inviteVisitor')->name('invite');
        Route::post('/edit', 'editVisitor')->name('edit');
        Route::post('/update', 'updateVisitor')->name('update');
        Route::post('/delete', 'deleteVisitor')->name('delete');
        Route::post('/status/update', 'updateStatus')->name('update.status');
        Route::post('/method/update', 'updateMethod')->name('update.method');

        Route::get('{visitorId}/visits', 'visits')->name('visits');
        Route::post('{visitorId}/visits/list', 'visitsList')->name('visits.list');
    });

    Route::controller(QuestionnaireController::class)->prefix('questionnaire')->name('questionnaire.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/list', 'list')->name('list');
        Route::post('/add-form', 'addForm')->name('add.form');
        Route::get('/{quid}/form', 'form')->name('form');
        Route::post('/rename', 'rename')->name('rename');
        Route::post('/save', 'save')->name('save');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::post('/delete', 'delete')->name('delete');
        Route::post('/duplicate', 'duplicate')->name('duplicate');
        Route::post('/status-update', 'statusUpdate')->name('status.update');
        Route::post('/questions/list/{id}', 'getQuestionsByCategory')->name('questions.list');
        Route::post('/add-new-questions/{id}', 'addNewQuestion')->name('add.new.question');

        Route::post('/clone', 'clone')->name('clone');

        Route::post('/update-status', 'updateStatus')->name('update.status');
        Route::post('/update-publish', 'changePublish')->name('update.publish');

        Route::post('/update-images', 'uploadImages')->name('upload.images');

        // Category CRUD routes
        Route::post('/category/add', 'addCategory')->name('category.add');
        Route::post('/category/edit', 'editCategory')->name('category.edit');
        Route::post('/category/update', 'updateCategory')->name('category.update');
        Route::post('/category/delete', 'deleteCategory')->name('category.delete');
        Route::post('/category/list', 'listCategories')->name('category.list');

        // View CRUD routes
        Route::get('{quid}/view', 'viewQuestionnaires')->name('view');

        Route::get('/{visitId}/response', 'questionnaireResponse')->name('response');
        Route::post('questionnaire-response-update/{id}', 'questionnaireResponseUpdate')->name('response.update');
        Route::post('questionnaire-response-submit', 'questionnaireResponseSubmit')->name('response.submit');
        Route::post('questionnaire-response-delete-comment-image', 'deleteCommentImage')->name('response.delete.comment.image');
        Route::post('questionnaire-response-comment-image', 'commentImage')->name('response.comment.image');
    });

    Route::controller(VisitController::class)->prefix('visit')->name('visit.')->group(function () {
        Route::get('/{page}', 'index')->name('index');
        Route::post('/list/{page}', 'list')->name('list');
        Route::post('/completed-list/{page}', 'completedList')->name('completed.list');

        Route::get('/create', 'create')->name('create');
        Route::post('/save', 'save')->name('save');
        Route::post('/edit', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::post('/delete', 'delete')->name('delete');
        Route::post('/duplicate', 'duplicate')->name('duplicate');
        Route::post('/update-status', 'updateStatus')->name('update.status');
        Route::post('/reject', 'reject')->name('reject');
        Route::post('/published', 'publishedStatus')->name('published');
        Route::post('/assign-visitor', 'assignVisitor')->name('assign.visitor');

        Route::get('/review/{report_uid}', 'visitReportReview')->name('report.review');
        Route::post('/report-status', 'visitReportStatus')->name('visitReportStatus');

        // Payment status toggle routes
        Route::post('/toggle-price-payment', 'togglePricePayment')->name('toggle.price.payment');
        Route::post('/toggle-reimbursement-payment', 'toggleReimbursementPayment')->name('toggle.reimbursement.payment');

        // PDF Actions
        Route::get('/generate-pdf/{visit_id}', 'generatePDF')->name('generate.pdf'); // View Report
        Route::get('/download-pdf/{visit_id}', 'downloadPDF')->name('download.pdf'); // Download Report
    });
    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout')->name('logout');
        Route::post('/update-name', 'updateName')->name('update-name');
        Route::post('/update-password', 'updatePassword')->name('update-password');
    });


    Route::controller(SettingController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings');
        Route::post('/account-update', 'accountUpdate')->name('account.update');
        Route::post('/announcement-update', 'announcementUpdate')->name('announcement.update');
        Route::post('/email-attachment-update', 'emailAttachmentUpdate')->name('email.attachment.update');
        Route::post('/email-attachment-delete', 'emailAttachmentDelete')->name('email.attachment.delete');
        Route::get('/faq', 'faq')->name('settings.faq');
        Route::post('/faq-action', 'faqAction')->name('settings.faq.action');
        Route::get('/guides', 'guides')->name('settings.guides');
        Route::post('/guides-action', 'guidesAction')->name('settings.guides.action');
        Route::post('/guides-file-delete', 'guidesFileDelete')->name('settings.guides.file.delete');
        Route::post('/guides-get-file', 'getGuidesFile')->name('settings.guides.get.file');
    });

    Route::controller(EmailController::class)->prefix('emails')->name('emails.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/{template}/update', 'update')->name('update');
        Route::post('/{template}/send-test', 'sendTest')->name('send-test');
        Route::post('/ckeditor/upload','upload')->name('ckeditor.upload');
    });
});
