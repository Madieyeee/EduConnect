<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ExportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Public school and program browsing
Route::prefix('public')->group(function () {
    Route::get('schools', [SchoolController::class, 'index']);
    Route::get('schools/{school}', [SchoolController::class, 'show']);
    Route::get('schools/{school}/programs', [ProgramController::class, 'getBySchool']);
    Route::get('programs', [ProgramController::class, 'index']);
    Route::get('programs/{program}', [ProgramController::class, 'show']);
    Route::get('schools/search', [SchoolController::class, 'search']);
    Route::get('programs/search', [ProgramController::class, 'search']);
});

// Public contact (no auth required)
Route::post('contact', [ContactController::class, 'store']);

// Protected routes (require authentication)
Route::middleware('auth:api')->group(function () {
    
    // Authentication routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
        Route::put('password', [AuthController::class, 'changePassword']);
    });

    // Student application routes
    Route::prefix('applications')->group(function () {
        Route::get('/', [ApplicationController::class, 'index']);
        Route::post('/', [ApplicationController::class, 'store']);
        Route::get('/{application}', [ApplicationController::class, 'show']);
        Route::put('/{application}', [ApplicationController::class, 'update']);
        Route::delete('/{application}', [ApplicationController::class, 'destroy']);
        Route::get('/{application}/documents/{document}', [ApplicationController::class, 'downloadDocument']);
        Route::get('/my/statistics', [ApplicationController::class, 'myStatistics']);
    });

    // Contact routes for authenticated users
    Route::prefix('contacts')->group(function () {
        Route::get('my', [ContactController::class, 'myContacts']);
    });

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        
        // School management
        Route::prefix('admin/schools')->group(function () {
            Route::get('/', [SchoolController::class, 'index']);
            Route::post('/', [SchoolController::class, 'store']);
            Route::get('/{school}', [SchoolController::class, 'show']);
            Route::put('/{school}', [SchoolController::class, 'update']);
            Route::delete('/{school}', [SchoolController::class, 'destroy']);
            Route::get('/{school}/applications', [ApplicationController::class, 'getBySchool']);
            Route::get('/{school}/statistics', [SchoolController::class, 'statistics']);
            Route::post('/{school}/upload-logo', [SchoolController::class, 'uploadLogo']);
            Route::post('/{school}/upload-banner', [SchoolController::class, 'uploadBanner']);
        });

        // Program management
        Route::prefix('admin/programs')->group(function () {
            Route::get('/', [ProgramController::class, 'index']);
            Route::post('/', [ProgramController::class, 'store']);
            Route::get('/{program}', [ProgramController::class, 'show']);
            Route::put('/{program}', [ProgramController::class, 'update']);
            Route::delete('/{program}', [ProgramController::class, 'destroy']);
            Route::get('/{program}/applications', [ApplicationController::class, 'getByProgram']);
            Route::get('/{program}/statistics', [ProgramController::class, 'statistics']);
        });

        // Application management
        Route::prefix('admin/applications')->group(function () {
            Route::get('/', [ApplicationController::class, 'index']);
            Route::get('/{application}', [ApplicationController::class, 'show']);
            Route::put('/{application}', [ApplicationController::class, 'update']);
            Route::put('/{application}/status', [ApplicationController::class, 'updateStatus']);
            Route::delete('/{application}', [ApplicationController::class, 'destroy']);
            Route::get('/{application}/documents/{document}', [ApplicationController::class, 'downloadDocument']);
            Route::get('/statistics/overview', [ApplicationController::class, 'statistics']);
            Route::get('/statistics/by-school', [ApplicationController::class, 'statisticsBySchool']);
            Route::get('/statistics/by-program', [ApplicationController::class, 'statisticsByProgram']);
        });

        // Contact management
        Route::prefix('admin/contacts')->group(function () {
            Route::get('/', [ContactController::class, 'index']);
            Route::get('/{contact}', [ContactController::class, 'show']);
            Route::put('/{contact}', [ContactController::class, 'update']);
            Route::post('/{contact}/assign', [ContactController::class, 'assign']);
            Route::get('/statistics/overview', [ContactController::class, 'statistics']);
        });

        // Export routes
        Route::prefix('admin/export')->group(function () {
            Route::get('statistics', [ExportController::class, 'getExportStatistics']);
            Route::get('students', [ExportController::class, 'exportStudents']);
            Route::get('applications', [ExportController::class, 'exportApplications']);
            Route::get('schools', [ExportController::class, 'exportSchools']);
            Route::get('contacts', [ExportController::class, 'exportContacts']);
            Route::get('financial-report', [ExportController::class, 'exportFinancialReport']);
        });

        // Dashboard statistics
        Route::prefix('admin/dashboard')->group(function () {
            Route::get('overview', [ApplicationController::class, 'dashboardOverview']);
            Route::get('recent-applications', [ApplicationController::class, 'recentApplications']);
            Route::get('recent-contacts', [ContactController::class, 'recentContacts']);
            Route::get('commission-summary', [ApplicationController::class, 'commissionSummary']);
        });
    });
});
