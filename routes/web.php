<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CrossoverController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController; // تأكد من إضافة متحكم المستخدمين
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// مسار تسجيل الخروج
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// تأكد من أن المستخدم مسجل الدخول قبل الوصول إلى هذه المسارات
Route::middleware(['auth'])->group(function () {

    // لوحة التحكم
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // مسارات إدارة العملاء
    Route::resource('clients', ClientController::class)->except(['show']);
    Route::get('clients/search', [ClientController::class, 'search'])->name('clients.search');

    // مسارات إعدادات الوحدات
    Route::resource('units', UnitController::class)->except(['show']);

    // مسارات إعدادات الضرائب
    Route::resource('taxes', TaxController::class)->except(['show']);

    // مسارات الفواتير
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/search', [InvoiceController::class, 'search'])->name('invoices.search');
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('invoices/{invoice}/download/{format}', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('invoices/{invoice}/add-payment', [InvoiceController::class, 'addPayment'])->name('invoices.addPayment');

    // مسارات صفحة العبور
    Route::get('/crossover', [CrossoverController::class, 'show'])->name('crossover');
    Route::post('/crossover', [CrossoverController::class, 'store'])->name('crossover.store');
    Route::get('/crossover/{id}/edit', [CrossoverController::class, 'edit'])->name('crossover.edit');
    Route::put('/crossover/{id}', [CrossoverController::class, 'update'])->name('crossover.update');
    Route::delete('/crossover/{id}', [CrossoverController::class, 'destroy'])->name('crossover.destroy');

    // مسارات المصاريف
    Route::resource('expenses', ExpenseController::class);

    // حماية مسارات إدارة المستخدمين بدور "admin"
    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('users', UserController::class); // مسارات إدارة المستخدمين
        Route::resource('roles', RoleController::class); // مسارات أدوار المستخدمين
    });

});
