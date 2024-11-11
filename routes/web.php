<?php

use Illuminate\Support\Facades\Route;




use App\Http\Controllers\User\UserController;
use App\Http\Controllers\role\RoleController;
use App\Http\Controllers\ProfileSettings\ProfileSettingsController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\FrontEnd\Auth\RegisterController;
use App\Http\Controllers\SubCategory\SubCategoryController;
use App\Http\Controllers\Items\ItemsController;
use App\Http\Controllers\Reviews\ReviewsController;
use App\Http\Controllers\TerAndCondition\TermAndConditionController;
use App\Http\Controllers\PrivacyPolicy\PrivacyPolicyController;
use App\Http\Controllers\SEO\SEOController;
use App\Http\Controllers\FrontEnd\HomePage\HomePageController;
use App\Http\Controllers\FrontEnd\Checkout\CheckoutController;
use App\Http\Controllers\FrontEnd\Auth\LoginController;
use App\Http\Controllers\FrontEnd\Payment\PaymentController;
use App\Http\Controllers\Auth\CutomForgotPasswordController;
use Illuminate\Support\Facades\Artisan;
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

// Home Page
// Route::redirect('/', '/home');
Route::get("/", [HomePageController::class, "index"]);

Route::get("/checkout/{id}", [CheckoutController::class, "index"])->name("checkout");
Route::post('/checkout/process-payment', [CheckoutController::class, "processPayment"])->name('process.payment');
Route::get("/signup", [RegisterController::class, "index"])->name("signup");
Route::get("/register", [RegisterController::class, "register"])->name("register");
Route::post("/signup/store", [RegisterController::class, "register"])->name("registerUser");
Route::get('/user-login', [LoginController::class, 'index']);
Route::post('/user-post-login', [LoginController::class, 'postLogin'])->name('user-login-post'); 
Route::get('/user-login/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/user-login/google/callback', [LoginController::class, 'handleGoogleCallback']);

// user register
Route::post('/post-registration', [RegisterController::class, 'postRegistration'])->name('user-register-post');
Route::post('/user-create-checkout', [RegisterController::class, 'userCreateCheckout'])->name('user-create-checkout');
Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent'])->name('create-payment-intent');
Route::get('/thankyou', function () { return view('Thankyou.thankyou'); })->name('thankyou');
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboardv1');
    })->name('dashboard');

    //User Module
    Route::get('/user',[UserController::class,'index'])->name('user-index');
    Route::post('/user/store',[UserController::class,'store'])->name('user-store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user-edit');
    Route::get('/user/delete/{id}', [UserController::class, 'remove'])->name('user-delete');
    Route::get('/user/sendResetPassword/{email}', [UserController::class, 'sendResetPassword'])->name('user-send-reset-password');

    //Role Module
    Route::resource('roles', RoleController::class);

    //Profile Settings Module
    Route::get('/profilesettings/{id}',[ProfileSettingsController::class,'index'])->name('profile-settings');
    Route::post('/profilesettings/store',[ProfileSettingsController::class,'store'])->name('profilesettings-store');
    Route::get('/changePassword', [ProfileSettingsController::class, 'showChangePasswordGet'])->name('changePasswordGet');
    Route::post('/changePassword', [ProfileSettingsController::class, 'changePasswordPost'])->name('changePasswordPost');

    //Settings Module
    Route::get('/settings',[SettingsController::class,'index'])->name('settings-index');
    Route::post('/settings/store',[SettingsController::class,'store'])->name('settings-store');

    // Category module
    Route::get('/category',[CategoryController::class,'index'])->name('category-index');
    Route::post('/category/store',[CategoryController::class,'store'])->name('category-store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category-edit');
    Route::get('/category/delete/{id}', [CategoryController::class, 'remove'])->name('category-delete');
    Route::post("/category/status/{id}", [CategoryController::class, "changeStatus"])->name("category-status");

    // Sub Category module
    Route::get('/sub-category',[SubCategoryController::class,'index'])->name('sub-category-index');
    Route::post('/sub-category/store',[SubCategoryController::class,'store'])->name('sub-category-store');
    Route::get('/sub-category/edit/{id}', [SubCategoryController::class, 'edit'])->name('sub-category-edit');
    Route::get('/sub-category/delete/{id}', [SubCategoryController::class, 'remove'])->name('sub-category-delete');
    Route::post("/sub-category/status/{id}", [SubCategoryController::class, "changeStatus"])->name("subcategory-status");

    // Items module
    Route::get('/items',[ItemsController::class,'index'])->name('items-index');
    Route::post('/items/store',[ItemsController::class,'store'])->name('items-store');
    Route::get('/items/edit/{id}', [ItemsController::class, 'edit'])->name('items-edit');
    Route::get('/items/delete/{id}', [ItemsController::class, 'remove'])->name('items-delete');
    Route::post("/items/status/{id}", [ItemsController::class, "changeStatus"])->name("items-status");
    Route::post("/items/get-subcategory", [ItemsController::class, "getSubCategory"])->name("get-subcategory");

    // Review module
    Route::get('/items-list', [ReviewsController::class,'items_list'])->name('items-list');
    Route::get('/items-list/{id}/reviews', [ReviewsController::class,'showReviews'])->name('reviews-list');
    Route::post("/review/status/{id}", [ReviewsController::class, "changeStatus"])->name("reviews-status");
    Route::get('/review/delete/{id}', [ReviewsController::class, 'remove'])->name('reviews-delete');

    // Term And Condition module
    Route::get('/term-condition',[TermAndConditionController::class,'index'])->name('term-condition-index');
    Route::post('/term-condition/store',[TermAndConditionController::class,'store'])->name('term-condition-store');
    Route::get('/term-condition/edit/{id}', [TermAndConditionController::class, 'edit'])->name('term-condition-edit');
    Route::get('/term-condition/delete/{id}', [TermAndConditionController::class, 'remove'])->name('term-condition-delete');

    // Privacy Policy module
    Route::get('/privacy-policy',[PrivacyPolicyController::class,'index'])->name('privacy-policy-index');
    Route::post('/privacy-policy/store',[PrivacyPolicyController::class,'store'])->name('privacy-policy-store');
    Route::get('/privacy-policy/edit/{id}', [PrivacyPolicyController::class, 'edit'])->name('privacy-policy-edit');
    Route::get('/privacy-policy/delete/{id}', [PrivacyPolicyController::class, 'remove'])->name('privacy-policy-delete');

    // SEO module
    Route::get('/SEO',[SEOController::class,'index'])->name('SEO-index');
    Route::post('/SEO/store',[SEOController::class,'store'])->name('SEO-store');
    Route::get('/SEO/edit/{id}', [SEOController::class, 'edit'])->name('SEO-edit');
    Route::get('/SEO/delete/{id}', [SEOController::class, 'remove'])->name('SEO-delete');

    Route::post("/payment", [PaymentController::class, "store"])->name("payment");
});

// forgot password
Route::get('forget-password', [CutomForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget-password-get');
Route::post('forget-password', [CutomForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget-password-post'); 
Route::get('reset-password/{token}', [CutomForgotPasswordController::class, 'showResetPasswordForm'])->name('reset-password-get');
Route::post('reset-password', [CutomForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset-password-post');


// Contact us
Route::get('/contact-us', function () { 
    return view('pages.Home.Contact'); 
})->name('contact-us');
Route::post('/user/contact-us', [UserController::class, 'contactUs'])->name('contactUs-send');

// Terms and Condition Page
Route::get('/terms-and-condition', [TermAndConditionController::class,'user_index']
)->name('terms-and-condition');

// Privacy Policy Page
Route::get('/user-privacy-policy', [PrivacyPolicyController::class,'user_index']
)->name('privacy-policy');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache cleared successfully";

});
