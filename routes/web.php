<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyTransportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [ PagesController::class, 'bus' ]);

Route::prefix('')->group(function () {
    Route::get('/signIn', [ AuthController::class, 'getSignIn' ]);
    Route::post('/signIn', [ AuthController::class, 'signIn' ]);
    Route::get('/signUp', [ AuthController::class, 'getSignUp' ]);
    Route::post('/signUp', [ AuthController::class, 'signUp' ]);
    Route::post('/logOut', [ AuthController::class, 'logOut' ])->name('logOut');

    Route::post('/bus/search', [ PagesController::class, 'search' ]);
    Route::get('/seat_allocations', [ PagesController::class, 'seat_allocations' ]);

    Route::post('/bus/booking', [ PagesController::class, 'prebooking' ]);
    Route::post('/charge', [ PagesController::class, 'completePayment' ]);

    Route::get('/print', [ PagesController::class, 'print' ]);
    Route::get('/print_invoice', [ PagesController::class, 'print_invoice' ]);

    Route::get('/contact', [ PagesController::class, 'contact_form' ]);
    Route::post('/contact', [ PagesController::class, 'contact_admin' ]);
});

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware([ 'auth', 'superAdmin' ])
    ->prefix('dashboard')
    ->group(function () {

        Route::get('/', [ DashboardController::class, 'index' ]);

        Route::prefix('users')->group(function () {
            Route::get('/', [ UserController::class, 'index' ]);
            Route::post('/{status}', [ UserController::class, 'updateStatus' ]);
        });

        Route::prefix('admins')->group(function () {
            Route::get('/', [ CompanyController::class, 'index' ]);
            Route::post('/{status}', [ CompanyController::class, 'updateStatus' ]);
        });

        Route::get('/all/trips', [ TripController::class, 'allTrips' ]);

        Route::prefix('all/transport_type')->group(function () {
            Route::get('/', [ TransportController::class, 'index' ]);
        });

        Route::get('/add/transport_type', [ TransportController::class, 'create' ]);
        Route::post('/add/transport', [ TransportController::class, 'store' ]);
        Route::post('/edit/{id}/transport', [ TransportController::class, 'update' ]);
        Route::post('/delete/{id}/transport', [ TransportController::class, 'destroy' ]);

        Route::get('/sales/reports', [ ReportController::class, 'allSalesReports' ]);
    });

/*
|--------------------------------------------------------------------------
| Company Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware([ 'auth', 'admin' ])
    ->prefix('company')
    ->group(function () {

        Route::get('/dashboard', [ DashboardController::class, 'companyAdmin' ]);

        Route::prefix('dashboard')->group(function () {
            Route::get('/all/trips', [ TripController::class, 'index' ]);
            Route::get('/add/trip', [ TripController::class, 'create' ]);
            Route::post('/add/trip', [ TripController::class, 'store' ]);
            Route::post('/edit/{id}/trip', [ TripController::class, 'update' ]);

            Route::get('/all/drivers', [ DriverController::class, 'index' ]);
            Route::get('/add/driver', [ DriverController::class, 'create' ]);
            Route::post('/add/driver', [ DriverController::class, 'store' ]);

            Route::get('/all/sales', [ ReportController::class, 'allSales' ]);
            Route::get('/sales/reports', [ ReportController::class, 'salesReports' ]);
        });

        Route::get('/add/transport', [ CompanyTransportController::class, 'create' ]);
        Route::post('/add/transport', [ CompanyTransportController::class, 'store' ]);

        Route::get('/all/buses', [ CompanyTransportController::class, 'allBuses' ]);
    });


Route::middleware([ 'auth' ])
    ->prefix('dashboard/users')
    ->group(function () {
        Route::get('/{user}', [ UserController::class, 'show' ]);
        Route::post('/{user}/update', [ UserController::class, 'update' ]);
        Route::post('/{user}/changePassword', [ UserController::class, 'passwordChange' ]);
    });
/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/
Route::middleware([ 'auth', 'client' ])->group(function () {
    Route::post('/company/register', [ CompanyController::class, 'store' ]);
    Route::get('/member', [ PagesController::class, 'memberCheck' ]);
});
