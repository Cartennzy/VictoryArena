<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\CustomerDataController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerProfileController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicLandingController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| LANDING PAGE & PUBLIC STATS
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicLandingController::class, 'index'])->name('landing');

Route::get('/landing-live-stats', function () {
    return response()->json([
        'bookings' => \DB::table('reservations')
            ->where('status', 'approved')
            ->count()
    ]);
});

/*
|--------------------------------------------------------------------------
| PUBLIC JADWAL GRID (HYBRID ROUTE)
|--------------------------------------------------------------------------
*/
Route::get('/jadwal-grid', [CustomerBookingController::class, 'jadwalGrid'])->name('jadwal.grid');

/*
|--------------------------------------------------------------------------
| SMART BOOKING ENTRY (REDIRECT PENGUNJUNG NON-LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/booking', function (Request $request) {
    if (!Auth::check()) {
        return redirect()->route('login', [
            'redirect'   => 'booking',
            'field'      => $request->query('field'),
            'date'       => $request->query('date'),
            'start_time' => $request->query('start_time'),
            'end_time'   => $request->query('end_time'),
        ])->with('info', 'Silakan login terlebih dahulu untuk melanjutkan reservasi.');
    }

    if (Auth::user()->role === 'admin') {
        return redirect()->route('dashboard');
    }

    if (empty(Auth::user()->phone)) {
        return redirect()->route('customer.customer.form')->with('warning', 'Silakan lengkapi data diri Anda terlebih dahulu.');
    }

    return app(CustomerBookingController::class)->create($request);
})->name('customer.booking');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION (LOGIN & LOGOUT)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| REGISTER CUSTOMER
|--------------------------------------------------------------------------
*/
Route::get('/register-customer', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
Route::post('/register-customer', [CustomerAuthController::class, 'register'])->name('customer.register.store');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (PROTECTED BY ROLE:ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Explicit Named Routes untuk Kelola Reservasi Admin
    Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/admin/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/admin/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/admin/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    Route::resource('customers', CustomerController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER AREA (PROTECTED BY ROLE:CUSTOMER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

    // Data Customer Wajib
    Route::get('/customer/data', [CustomerDataController::class, 'create'])->name('customer.customer.form');
    Route::post('/customer/data', [CustomerDataController::class, 'store'])->name('customer.customer.store');

    // Booking & Riwayat Khusus Customer
    Route::middleware(['customer.data'])->group(function () {
        Route::get('/reservations', [CustomerBookingController::class, 'index'])->name('customer.reservations.index');
        Route::post('/booking', [CustomerBookingController::class, 'store'])->name('customer.booking.store');
        Route::get('/booking/schedule', [CustomerBookingController::class, 'getBookedSchedule'])->name('customer.booking.schedule');
    });

    // View Kalender Jadwal Tersedia
    Route::get('/customer/schedules', [CustomerBookingController::class, 'schedulesIndex'])->name('customer.schedules.index');

    // Customer Payment (Midtrans Gateway)
    Route::get('/payment/{id}', [PaymentController::class, 'payReservation'])->name('payment.midtrans');
    Route::get('/payment/success/{order_id}', [PaymentController::class, 'success'])->name('payment.success');
    Route::post('/payment/upload/{reservation}', [PaymentController::class, 'uploadProof'])->name('payment.upload');
    Route::match(['get', 'post'], '/payment/simulate/{order_id}', [PaymentController::class, 'simulatePayment'])->name('payment.simulate');

    // Profil Member & Keamanan Akun
    Route::get('/customer/profile', [CustomerProfileController::class, 'index'])->name('customer.profile');
    Route::post('/customer/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::post('/customer/profile/password', [CustomerProfileController::class, 'changePassword'])->name('customer.profile.password');
});

/*
|--------------------------------------------------------------------------
| MIDTRANS WEBHOOK CALLBACK
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [PaymentController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| GOOGLE OAUTH
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.redirect');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::updateOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name'     => $googleUser->getName(),
            'password' => bcrypt('google_login'),
            'role'     => 'customer'
        ]
    );

    Auth::login($user);
    return redirect()->route('customer.dashboard');
});