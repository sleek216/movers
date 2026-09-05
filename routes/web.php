<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\DriverManagementController;
use App\Http\Controllers\Admin\LorryController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\LoadBookingController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\RouteCalculatorController;

use App\Http\Controllers\LandingController;

/*
|--------------------------------------------------------------------------
| Public Routes - Movers Freight & Logistics Landing & Legal Portal
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing.home');
Route::get('/about', [LandingController::class, 'about'])->name('landing.about');
Route::get('/services', [LandingController::class, 'services'])->name('landing.services');
Route::get('/fare-calculator', [LandingController::class, 'calculator'])->name('landing.calculator');
Route::post('/api/calculate-fare', [LandingController::class, 'calculateFare'])->name('landing.calculateFare');
Route::get('/terms-conditions', [LandingController::class, 'terms'])->name('landing.terms');
Route::get('/privacy-policy', [LandingController::class, 'privacy'])->name('landing.privacy');
Route::get('/faq', [LandingController::class, 'faq'])->name('landing.faq');
Route::get('/contact', [LandingController::class, 'contact'])->name('landing.contact');
Route::post('/contact', [LandingController::class, 'submitContact'])->name('landing.contact.submit');
Route::get('/download', [LandingController::class, 'download'])->name('landing.download');

// Admin root redirect
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

// Image direct route handler
Route::get('/images/{any}', function ($any) {
    $path = public_path('images/' . $any);
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
})->where('any', '.*');

// Admin Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Protected Admin Routes
Route::prefix('admin')->middleware(['admin.auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Customers (Users)
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}/status', [UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
    Route::post('/users/{id}/verify', [UserController::class, 'verifyDocument'])->name('admin.users.verifyDocument');
    Route::get('/users/{id}/wallet', [UserController::class, 'wallet'])->name('admin.users.wallet');
    Route::post('/users/{id}/adjust-wallet', [UserController::class, 'adjustWallet'])->name('admin.users.adjustWallet');

    // Transporters (Lorry Owners)
    Route::get('/owners', [OwnerController::class, 'index'])->name('admin.owners.index');
    Route::post('/owners/{id}/status', [OwnerController::class, 'toggleStatus'])->name('admin.owners.toggleStatus');
    Route::post('/owners/{id}/verify', [OwnerController::class, 'verifyDocument'])->name('admin.owners.verifyDocument');
    Route::post('/owners/{id}/commission', [OwnerController::class, 'updateCommission'])->name('admin.owners.updateCommission');

    // Fleet Drivers Directory
    Route::get('/drivers', [DriverManagementController::class, 'index'])->name('admin.drivers.index');
    Route::post('/drivers', [DriverManagementController::class, 'store'])->name('admin.drivers.store');
    Route::post('/drivers/{id}/update', [DriverManagementController::class, 'update'])->name('admin.drivers.update');
    Route::delete('/drivers/{id}', [DriverManagementController::class, 'destroy'])->name('admin.drivers.destroy');

    // Lorry Fleet
    Route::get('/lorries', [LorryController::class, 'index'])->name('admin.lorries.index');
    Route::get('/lorries/{id}/show', [LorryController::class, 'show'])->name('admin.lorries.show');
    Route::post('/lorries/{id}/verify', [LorryController::class, 'verify'])->name('admin.lorries.verify');
    Route::post('/lorries/{id}/status', [LorryController::class, 'toggleStatus'])->name('admin.lorries.toggleStatus');

    // Vehicle Categories
    Route::resource('vehicles', VehicleController::class, ['as' => 'admin']);
    Route::post('/vehicles/{id}/status', [VehicleController::class, 'toggleStatus'])->name('admin.vehicles.toggleStatus');

    // Route Calculator & Rates Matrix
    Route::get('/calculator-settings', [RouteCalculatorController::class, 'index'])->name('admin.calculator.index');
    Route::post('/calculator-settings', [RouteCalculatorController::class, 'update'])->name('admin.calculator.update');

    // Banners
    Route::get('/banners', [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
    Route::post('/banners/{id}/status', [BannerController::class, 'toggleStatus'])->name('admin.banners.toggleStatus');

    // Load Bookings
    Route::get('/loads', [LoadBookingController::class, 'index'])->name('admin.loads.index');
    Route::get('/loads/{id}/show', [LoadBookingController::class, 'show'])->name('admin.loads.show');
    Route::get('/loads/{status}', [LoadBookingController::class, 'index'])->name('admin.loads.byStatus');
    // Digital Bilty & Adda Register
    Route::get('/bilties', [\App\Http\Controllers\Admin\BiltyController::class, 'index'])->name('admin.bilties.index');
    Route::get('/bilties/{id}/show', [\App\Http\Controllers\Admin\BiltyController::class, 'show'])->name('admin.bilties.show');
    Route::get('/bilties/{id}/print', [\App\Http\Controllers\Admin\BiltyController::class, 'print'])->name('admin.bilties.print');
    Route::delete('/bilties/{id}', [\App\Http\Controllers\Admin\BiltyController::class, 'destroy'])->name('admin.bilties.destroy');

    // Movers Communities & Groups Management
    Route::get('/communities', [\App\Http\Controllers\Admin\CommunityController::class, 'index'])->name('admin.communities.index');
    Route::post('/communities', [\App\Http\Controllers\Admin\CommunityController::class, 'store'])->name('admin.communities.store');
    Route::post('/communities/{id}/update', [\App\Http\Controllers\Admin\CommunityController::class, 'update'])->name('admin.communities.update');
    Route::delete('/communities/{id}', [\App\Http\Controllers\Admin\CommunityController::class, 'destroy'])->name('admin.communities.destroy');
    Route::get('/communities/{id}/messages', [\App\Http\Controllers\Admin\CommunityController::class, 'messages'])->name('admin.communities.messages');
    Route::delete('/communities/messages/{id}', [\App\Http\Controllers\Admin\CommunityController::class, 'destroyMessage'])->name('admin.communities.destroyMessage');

    // Master Data: States
    Route::get('/states', [MasterDataController::class, 'states'])->name('admin.states.index');
    Route::post('/states', [MasterDataController::class, 'storeState'])->name('admin.states.store');
    Route::delete('/states/{id}', [MasterDataController::class, 'deleteState'])->name('admin.states.destroy');
    Route::post('/states/{id}/status', [MasterDataController::class, 'toggleStateStatus'])->name('admin.states.toggleStatus');

    // Master Data: Country Codes
    Route::get('/country-codes', [MasterDataController::class, 'countryCodes'])->name('admin.country_codes.index');
    Route::post('/country-codes', [MasterDataController::class, 'storeCountryCode'])->name('admin.country_codes.store');
    Route::delete('/country-codes/{id}', [MasterDataController::class, 'deleteCountryCode'])->name('admin.country_codes.destroy');

    // Master Data: FAQs
    Route::get('/faqs', [MasterDataController::class, 'faqs'])->name('admin.faqs.index');
    Route::post('/faqs', [MasterDataController::class, 'storeFaq'])->name('admin.faqs.store');
    Route::delete('/faqs/{id}', [MasterDataController::class, 'deleteFaq'])->name('admin.faqs.destroy');

    // Master Data: Pages
    Route::get('/pages', [MasterDataController::class, 'pages'])->name('admin.pages.index');
    Route::post('/pages', [MasterDataController::class, 'storePage'])->name('admin.pages.store');
    Route::put('/pages/{id}', [MasterDataController::class, 'updatePage'])->name('admin.pages.update');
    Route::delete('/pages/{id}', [MasterDataController::class, 'deletePage'])->name('admin.pages.destroy');

    // Payment Gateways
    Route::get('/payments', [PaymentGatewayController::class, 'index'])->name('admin.payments.index');
    Route::get('/payments/{id}/edit', [PaymentGatewayController::class, 'edit'])->name('admin.payments.edit');
    Route::put('/payments/{id}', [PaymentGatewayController::class, 'update'])->name('admin.payments.update');

    // Transporter Payouts & Earning Reports
    Route::get('/payouts', [PayoutController::class, 'index'])->name('admin.payouts.index');
    Route::post('/payouts/{id}/status', [PayoutController::class, 'updateStatus'])->name('admin.payouts.updateStatus');
    Route::get('/earning-report', [PayoutController::class, 'earningReport'])->name('admin.payouts.earnings');

    // App & Platform Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // Admin Profile & Security
    Route::get('/profile', [SettingController::class, 'profile'])->name('admin.settings.profile');
    Route::post('/profile', [SettingController::class, 'updateProfile'])->name('admin.settings.updateProfile');
});
