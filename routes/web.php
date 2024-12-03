<?php

use App\Http\Controllers\Admin\Artist\ArtistController;
use App\Http\Controllers\Admin\Sales\SalesController;
use App\Http\Controllers\Admin\Artworks\ArtworkController;
use App\Http\Controllers\Admin\Banner\BannerController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\artist\ArtworkController as ArtistArtworkController;
use App\Http\Controllers\artist\AuthController;
use App\Http\Controllers\artist\BannerController as ArtistBannerController;
use App\Http\Controllers\artist\DashboardController as ArtistDashboardController;
use App\Http\Controllers\Admin\Payment\PaymentController;
use App\Http\Controllers\Admin\Expenses\ExpensesController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
// Route::fallback(function(){
//     return response()->json([ 'Page Not Found.'], 404);
// });

Route::get('/', function () {
    return view('homeadmin');
})->name('homeadmin');


Route::get('/artist/login', function () {
    return view('userLogin');
})->name('artistLogin');

Route::get('/admin/login', function () {
    return view('auth/login');
})->name('adminLogin');

Route::get('/sales/login', function () {
    return view('auth/sales_login');
})->name('salesLogin');


Route::get('/user/logout', [AuthController::class, 'logoutArtist'])->name('artist.logout');
Route::get('/sales/logout', [AuthController::class, 'logoutSales'])->name('sales.logout');
Route::get('/admin/logout', [AuthController::class, 'logoutAdmin'])->name('admin.logout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'adminCheck'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('artists', ArtistController::class);
    Route::post('/artisthold/{id}', [ArtistController::class, 'accounthold'])->name('artist.hold');


    Route::resource('artworks', ArtworkController::class);

    Route::resource('sales', SalesController::class);
    Route::get('/add-customer', [ArtistController::class, 'addCustomer'])->name('admin.addCustomer');
    Route::post('/store-customer', [ArtistController::class, 'storeCustomer'])->name('admin.storeCustomer');
    Route::get('/customers', [ArtistController::class, 'customers'])->name('admin.customers');
    Route::get('/customers/{id}', [ArtistController::class, 'editCustomer'])->name('admin.editCustomer');
    Route::post('/customers/{id}', [ArtistController::class, 'updateCustomer'])->name('admin.updateCustomer');
    Route::delete('/customers/{id}', [ArtistController::class, 'destroyCustomer'])->name('admin.destroyCustomer');

    Route::delete('/delete-comment/{id}', [ArtworkController::class, 'deleteComment'])->name('comment.delete');

    Route::resource('banners', BannerController::class);

    Route::get('/impersonate/{salesExeID}', [DashboardController::class, 'impersonate'])->name('admin.impersonate');
    Route::get('/revert-impersonate', [DashboardController::class, 'revertImpersonate'])->name('admin.revert.impersonate');

    Route::get('/impersonateartist/{salesExeID}', [DashboardController::class, 'impersonateartist'])->name('admin.impersonateartist');
    Route::get('/revert-impersonatesales', [DashboardController::class, 'revertImpersonateforsales'])->name('admin.revert.revertImpersonateforsales');


});

Route::post('/quotes', [DashboardController::class, 'storeQuote'])->name('admin.storeQuote');
Route::get('/get-quote', [DashboardController::class, 'getQuote'])->name('admin.getQuote');
Route::get('/get-appointment', [DashboardController::class, 'getAppointment'])->name('admin.getAppointment');
Route::get('/get-deposit-slips', [PaymentController::class, 'getDepositSlips'])->name('admin.deposit-slips');
Route::post('/get-filter-deposit', [PaymentController::class, 'getFilteredDeposits'])->name('admin.filterDeposite');
Route::get('/print-deposit-pdf', [PaymentController::class, 'printDepositPDF'])->name('admin.printDepositPDF');

Route::post('/send-link', [DashboardController::class, 'SendLink'])->name('admin.SendLink');
Route::get('/form-link-url/{user_id}/{artist_id}/{dbid}', [DashboardController::class, 'formlinkurl'])->name('admin.formlinkurl');
Route::get('/success', [DashboardController::class, 'success'])->name('admin.success');
Route::get('/error', [DashboardController::class, 'error'])->name('admin.error');
Route::post('/userformsubmit', [DashboardController::class, 'userformsubmit'])->name('admin.userformsubmit');

Route::get('/get-accept-payment', [PaymentController::class, 'getAcceptPayment'])->name('admin.getAcceptPayment');
Route::get('/add-payment', [PaymentController::class, 'AddpaymentForm'])->name('admin.AddpaymentForm');
Route::post('/add-payment-post', [PaymentController::class, 'AddpaymentPost'])->name('admin.AddpaymentPost');
Route::get('/print-payment-slip/{id}', [PaymentController::class, 'paymentview'])->name('admin.paymentview');

Route::get('/edit-payment/{id}', [PaymentController::class, 'editpaymentForm'])->name('admin.editpaymentForm');
Route::post('/edit-payment-post/{id}', [PaymentController::class, 'editpaymentPost'])->name('admin.editpaymentPost');
Route::delete('/payment-delete/{id}', [PaymentController::class, 'deletepaymentForm'])->name('admin.deletepaymentForm');

Route::get('/get-expenses', [ExpensesController::class, 'getExpenses'])->name('admin.getExpenses');
Route::get('/add-expenses', [ExpensesController::class, 'AddexpensesForm'])->name('admin.AddexpensesForm');
Route::post('/add-expenses-post', [ExpensesController::class, 'AddexpensesPost'])->name('admin.AddexpensesPost');
Route::get('/edit-expenses/{id}', [ExpensesController::class, 'editexpensesForm'])->name('admin.editexpensesForm');
Route::post('/edit-expenses-post/{id}', [ExpensesController::class, 'editexpensesPost'])->name('admin.editexpensesPost');
Route::delete('/expenses-delete/{id}', [ExpensesController::class, 'deleteexpensesForm'])->name('admin.deleteexpensesForm');
Route::get('/expenses/print', [ExpensesController::class, 'printExpenses'])->name('admin.printExpenses');




Route::delete('/delete-quote/{id}', [DashboardController::class, 'deleteQuote'])->name('quote.delete');
Route::delete('/delete-appointment/{id}', [DashboardController::class, 'deleteAppointment'])->name('appointment.delete');

Route::get('/all-comment', [ArtworkController::class, 'allComment'])->name('admin.allComment');

Route::get('/walk-in', [DashboardController::class, 'getWalkIn'])->name('artists.getWalkIn');


Route::post('userlogin', [AuthController::class, 'userlogin'])->name('userlogin');
// 'middleware' => 'artistCheck'
// 'middleware' => 'artistCheck'
Route::group(['prefix' => 'user','middleware' => 'ArtistBlockChack'], function () {
    Route::get('/artist-dashboard', [ArtistDashboardController::class, 'index'])->name('artists.dashboard');
    Route::get('/artist-profile', [ArtistDashboardController::class, 'profile'])->name('artists.profile');
    Route::put('/artist-profile/{id}', [ArtistController::class, 'update'])->name('artists.profileUpdate');

    Route::get('/artwork-get', [ArtistArtworkController::class, 'getArtistWiseArtwork'])->name('artists.getArtistWiseArtwork');
    Route::get('/artwork-upload', [ArtistArtworkController::class, 'getForm'])->name('artists.getForm');
    Route::post('/artwork-upload', [ArtistArtworkController::class, 'uploadArtistWiseArtwork'])->name('artists.uploadArtistWiseArtwork');
    Route::get('/artwork-edit/{id}', [ArtistArtworkController::class, 'editArtwork'])->name('artist.editArtwork');
    Route::put('/artwork-edit/{id}', [ArtistArtworkController::class, 'updateArtwork'])->name('artist.updateArtwork');
    Route::delete('/artwork-delete/{id}', [ArtistArtworkController::class, 'destroyArtwork'])->name('artist.destroyArtwork');

    Route::get('/carousel-get', [ArtistBannerController::class, 'getArtistWiseBanner'])->name('artists.getArtistWiseBanner');
    Route::get('/editcarousel-carousel/{id}', [ArtistBannerController::class, 'editArtistWiseBanner'])->name('artists.getArtistWiseBanneredit');
    Route::post('/artist/carousel/update/{id}', [ArtistBannerController::class, 'updateArtistWiseBanner'])->name('artists.updateArtistWiseBanner');
    Route::get('/carousel-upload', [ArtistBannerController::class, 'getForm'])->name('artists.bgetForm');
    Route::post('/carousel-upload', [ArtistBannerController::class, 'uploadArtistWiseBanner'])->name('artists.uploadArtistWiseBanner');
    Route::delete('/carousel-delete/{id}', [ArtistBannerController::class, 'destroyBanner'])->name('artists.destroyBanner');

    Route::get('/add-customer', [ArtistController::class, 'addCustomer'])->name('admin.addCustomer');
    Route::post('/store-customer', [ArtistController::class, 'storeCustomer'])->name('admin.storeCustomer');
    Route::get('/customers', [ArtistController::class, 'customers'])->name('admin.customers');
    Route::get('/customers/{id}', [ArtistController::class, 'editCustomer'])->name('admin.editCustomer');
    Route::post('/customers/{id}', [ArtistController::class, 'updateCustomer'])->name('admin.updateCustomer');
    Route::delete('/customers/{id}', [ArtistController::class, 'destroyCustomer'])->name('admin.destroyCustomer');

    Route::get('/admin/get-payment-methods', [PaymentController::class, 'getPaymentMethods'])->name('admin.getPaymentMethods');
    Route::get('/admin/subscriptions', [SubscriptionController::class, 'index'])->name('admin.subscriptions');

    Route::get('/admin/subscriptions/create', [SubscriptionController::class, 'create'])->name('admin.subscriptions.create');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    // Route to display the subscription edit form
Route::get('/admin/subscriptions/{id}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');

// Route to handle the subscription update form submission
Route::put('/admin/subscriptions/{id}', [SubscriptionController::class, 'update'])->name('subscriptions.update');


});

Route::get('artistblock', function () {
    if(Auth::guard('artists')->user()->account_hold == 1) {
        return view('block');
    }
    return redirect()->route('artists.dashboard');
  
})->name('artistblock');
