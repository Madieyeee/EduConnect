<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
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

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/schools', [HomeController::class, 'schools'])->name('schools.index');
Route::get('/schools/{school}', [HomeController::class, 'showSchool'])->name('schools.show');

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Student routes (protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-applications', [StudentController::class, 'applications'])->name('student.applications');
    Route::get('/apply/{school}', [StudentController::class, 'showApplicationForm'])->name('student.apply');
    Route::post('/apply/{school}', [StudentController::class, 'storeApplication']);
    Route::get('/applications/{application}', [StudentController::class, 'showApplication'])->name('student.applications.show');
});

// Admin routes (protected)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Schools management
    Route::get('/schools', [AdminController::class, 'schools'])->name('schools.index');
    Route::get('/schools/create', [AdminController::class, 'createSchool'])->name('schools.create');
    Route::post('/schools', [AdminController::class, 'storeSchool'])->name('schools.store');
    Route::get('/schools/{school}/edit', [AdminController::class, 'editSchool'])->name('schools.edit');
    Route::put('/schools/{school}', [AdminController::class, 'updateSchool'])->name('schools.update');
    Route::delete('/schools/{school}', [AdminController::class, 'destroySchool'])->name('schools.destroy');
    
    // Applications management
    Route::get('/applications', [AdminController::class, 'applications'])->name('applications.index');
    Route::get('/applications/{application}', [AdminController::class, 'showApplication'])->name('applications.show');
    Route::put('/applications/{application}/status', [AdminController::class, 'updateApplicationStatus'])->name('applications.update-status');
});
