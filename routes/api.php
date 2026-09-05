<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\LoadController;
use App\Http\Controllers\Api\LorryController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| Movers User App REST API Routes
|--------------------------------------------------------------------------
*/

// Authentication & OTP
Route::post('reg_user.php', [AuthController::class, 'register']);
Route::post('login_user.php', [AuthController::class, 'login']);
Route::post('update_fcm.php', [AuthController::class, 'updateFcm']);
Route::post('mobile_check.php', [AuthController::class, 'mobileCheck']);
Route::post('send_otp.php', [AuthController::class, 'sendOtp']);
Route::post('forget_password.php', [AuthController::class, 'forgotPassword']);

// Common & Master Data
Route::post('country_code.php', [CommonController::class, 'countryCodes']);
Route::post('home_page.php', [CommonController::class, 'homePage']);
Route::post('vehicle_list.php', [CommonController::class, 'vehicles']);
Route::match(['get', 'post'], 'calculator_settings.php', [CommonController::class, 'calculatorSettings']);
Route::match(['get', 'post'], 'ai_parse_route.php', [CommonController::class, 'aiParseRoute']);
Route::post('getstateid.php', [CommonController::class, 'states']);
Route::post('faq.php', [CommonController::class, 'faqs']);
Route::post('pagelist.php', [CommonController::class, 'pages']);
Route::post('notification.php', [CommonController::class, 'notifications']);

// Post Load & Bidding
Route::post('post_load.php', [LoadController::class, 'createLoad']);
Route::post('edit_load.php', [LoadController::class, 'editLoad']);
Route::post('load_history.php', [LoadController::class, 'loadHistory']);
Route::post('load_details.php', [LoadController::class, 'loadDetails']);
Route::post('delete_load.php', [LoadController::class, 'deleteLoad']);
Route::post('make_decision.php', [LoadController::class, 'makeDecision']);

// Lorry & Booking
Route::post('find_lorry.php', [LorryController::class, 'findLorry']);
Route::post('book_lorry.php', [LorryController::class, 'bookLorry']);
Route::post('book_history.php', [LorryController::class, 'bookHistory']);
Route::post('book_details.php', [LorryController::class, 'bookDetails']);
Route::post('offer_decision.php', [LorryController::class, 'offerDecision']);
Route::post('rate_update.php', [LorryController::class, 'rateUpdate']);
Route::post('lorri_profile.php', [LorryController::class, 'lorryProfile']);
Route::post('trans_profile.php', [LorryController::class, 'transProfile']);

// Wallet & Payments
Route::post('wallet_report.php', [WalletController::class, 'walletReport']);
Route::post('wallet_up.php', [WalletController::class, 'walletUp']);
Route::post('paymentgateway.php', [WalletController::class, 'paymentGateways']);

// Profile & Verification
Route::post('personal_document.php', [ProfileController::class, 'uploadDocuments']);
Route::post('pro_image.php', [ProfileController::class, 'updateAvatar']);
Route::post('profile_edit.php', [ProfileController::class, 'updateProfile']);
Route::post('referdata.php', [ProfileController::class, 'referralData']);

// Real-Time Event & Status Synchronization
Route::post('realtime_sync.php', [\App\Http\Controllers\Api\RealtimeEventController::class, 'sync']);

// Community & Group Chat System
Route::post('community_groups.php', [\App\Http\Controllers\Api\CommunityChatController::class, 'getGroups']);
Route::post('community_messages.php', [\App\Http\Controllers\Api\CommunityChatController::class, 'getMessages']);
Route::post('community_send_message.php', [\App\Http\Controllers\Api\CommunityChatController::class, 'sendMessage']);
Route::post('community_join.php', [\App\Http\Controllers\Api\CommunityChatController::class, 'toggleJoin']);

// Driver Directory & Fleet Management
Route::post('driver_list.php', [\App\Http\Controllers\Api\DriverController::class, 'list']);
Route::post('driver_add.php', [\App\Http\Controllers\Api\DriverController::class, 'add']);
Route::post('driver_update.php', [\App\Http\Controllers\Api\DriverController::class, 'update']);
Route::post('driver_delete.php', [\App\Http\Controllers\Api\DriverController::class, 'delete']);

// 📄 Digital Bilty & Adda Consignment Management
Route::post('bilty_create.php', [\App\Http\Controllers\Api\BiltyController::class, 'create']);
Route::post('bilty_list.php', [\App\Http\Controllers\Api\BiltyController::class, 'list']);
Route::post('bilty_details.php', [\App\Http\Controllers\Api\BiltyController::class, 'details']);
Route::post('bilty_update_status.php', [\App\Http\Controllers\Api\BiltyController::class, 'updateStatus']);
Route::match(['get', 'post'], 'bilty/create', [\App\Http\Controllers\Api\BiltyController::class, 'create']);
Route::match(['get', 'post'], 'bilty/list', [\App\Http\Controllers\Api\BiltyController::class, 'list']);
Route::match(['get', 'post'], 'bilty/details/{id}', [\App\Http\Controllers\Api\BiltyController::class, 'details']);
Route::match(['get', 'post'], 'bilty/update_status', [\App\Http\Controllers\Api\BiltyController::class, 'updateStatus']);


