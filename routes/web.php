<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class,'getIndex']);
Route::get('shop', [MainController::class,'getShop']);
Route::get('new-arrivals', [MainController::class,'getNewArrivals']);
Route::get('best-sellers', [MainController::class,'getBestSellers']);
Route::get('product', [MainController::class,'getProduct']);
Route::get('reviews', [MainController::class,'getReviews']);

Route::get('cart', [MainController::class,'getCart']);
Route::get('use-coupon', [MainController::class,'getUseCoupon']);

Route::get('checkout', [MainController::class,'getCheckout']);
Route::post('checkout', [MainController::class,'postCheckout']);
Route::get('pod', [MainController::class,'getPOD']);
Route::post('pod', [MainController::class,'postPOD']);
Route::get('contact', [MainController::class,'getContact']);
Route::post('contact', [MainController::class,'postContact']);
Route::get('search', [MainController::class,'getSearch']);
Route::get('about', [MainController::class,'getAbout']);
Route::get('faq', [MainController::class,'getFAQ']);
Route::get('privacy-policy', [MainController::class,'getPrivacyPolicy']);
Route::get('returns', [MainController::class,'getReturnPolicy']);

Route::get('orders', [MainController::class,'getOrders']);
Route::get('anon-order', [MainController::class,'getAnonOrder']);
Route::post('anon-order', [MainController::class,'postAnonOrder']);
Route::get('receipt', [MainController::class,'getReceipt']);
Route::get('track', [MainController::class,'getTrack']);
Route::get('confirm-payment', [MainController::class,'getConfirmPayment']);
Route::post('confirm-payment', [MainController::class,'postConfirmPayment']);
Route::get('review-order', [MainController::class,'getReviewOrder']);
Route::post('review-order', [MainController::class,'postReviewOrder']);

Route::get('login', [LoginController::class,'getLogin']);
Route::get('register', [LoginController::class,'getRegister']);
Route::post('login', [LoginController::class,'postLogin']);
Route::post('register', [LoginController::class,'postRegister']);

Route::get('forgot-password', [LoginController::class,'getForgotPassword']);
Route::post('forgot-password', [LoginController::class,'postForgotPassword']);
Route::get('reset', [LoginController::class,'getPasswordReset']);
Route::post('reset', [LoginController::class,'postPasswordReset']);

Route::get('signout', [LoginController::class,'getLogout']);

Route::get('dashboard', [MainController::class,'getDashboard']);
Route::get('profile', [MainController::class,'getProfile']);
Route::post('profile', [MainController::class,'postProfile']);

Route::post('add-review', [MainController::class,'postAddReview']);

Route::get('add-to-cart', [MainController::class,'getAddToCart']);
Route::get('update-cart', [MainController::class,'getUpdateCart']);
Route::get('remove-from-cart', [MainController::class,'getRemoveFromCart']);


Route::get('wishlist', [MainController::class,'getWishlist']);
Route::get('add-to-wishlist', [MainController::class,'getAddToWishlist']);
Route::get('remove-from-wishlist', [MainController::class,'getRemoveFromWishlist']);
Route::get('add-to-compare', [MainController::class,'getAddToCompare']);
Route::get('remove-from-compare', [MainController::class,'getRemoveFromCompare']);
Route::get('compare', [MainController::class,'getCompare']);

Route::get('payment/callback', [PaymentController::class,'getPaymentCallback']);
Route::get('pay', [MainController::class,'getPay']);
Route::post('pay', [PaymentController::class,'postRedirectToGateway']);

Route::post('subscribe', [MainController::class,'postSubscribe']);

Route::post('sync-data', [MainController::class,'postSyncData']);
Route::get('zohoverify/{nn}', [MainController::class,'getZoho']);
Route::get('bomb', [MainController::class,'getBomb']);
Route::get('pdf', [MainController::class,'getPDFTest']);
Route::get('gdf', [MainController::class,'getDeliveryFee']);
Route::get('gc', [MainController::class,'getCouriers']);

Route::get('error', [MainController::class,'getError']);
Route::get('cps', [MainController::class,'getCpsTest']);

