<?php
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'nl'])) {
        session(['locale' => $locale]);
    }
    // return back();
    return redirect(request('redirect', url()->previous() ?: '/'));
})->name('lang.switch');
