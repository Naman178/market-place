<?php

use App\Http\Controllers\newsletter\NewsletterController;
use App\Http\Controllers\SentMail\SentMailController;
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
use App\Http\Controllers\FAQ\FAQController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog_category\BlogCategoryController;
use App\Http\Controllers\FrontEnd\HomePage\HomePageController;
use App\Http\Controllers\FrontEnd\Checkout\CheckoutController;
use App\Http\Controllers\FrontEnd\Auth\LoginController;
use App\Http\Controllers\FrontEnd\Payment\PaymentController;
use App\Http\Controllers\Auth\CutomForgotPasswordController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserProfile\UserProfileController;
use App\Http\Controllers\Stripe\StripePaymentController;
use App\Http\Controllers\Razorpay\RazorpayPaymentController;
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
Route::post("/newsletter", [HomePageController::class, "newsletter"])->name('newsletter');

Route::get("/checkout/{id}", [CheckoutController::class, "index"])->name("checkout");
Route::post('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
Route::post('/checkout/process-payment', [CheckoutController::class, "processPayment"])->name('process.payment');
Route::get("/signup", [RegisterController::class, "index"])->name("signup");
Route::get("/register", [RegisterController::class, "register"])->name("register");
Route::post("/signup/store", [RegisterController::class, "register"])->name("registerUser");
Route::get('/user-login', [LoginController::class, 'index'])->name('user-login');
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

    // front user dashboard
    Route::get('/user-dashboard', [UserController::class, 'userDashboard'])->name('user-dashboard');

    // Category module
    Route::get('/category',[CategoryController::class,'index'])->name('category-index');
    Route::post('/category/store',[CategoryController::class,'store'])->name('category-store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category-edit');
    Route::get('/category/delete/{id}', [CategoryController::class, 'remove'])->name('category-delete');
    Route::post("/category/status/{id}", [CategoryController::class, "changeStatus"])->name("category-status");

    //newsletter module
    Route::get('/newsletter', [NewsletterController::class,'index'])->name('newsletter');

    //email sent module
    Route::get('/email' , [SentMailController::class , 'index'])->name('email');
    Route::post('/email/preview', [SentMailController::class, 'preview'])->name('email-preview');
    Route::post('/email/store', [SentMailController::class, 'store'])->name('email-store');
    // Sub Category module
    Route::get('/sub-category',[SubCategoryController::class,'index'])->name('sub-category-index');
    Route::post('/sub-category/store',[SubCategoryController::class,'store'])->name('sub-category-store');
    Route::get('/sub-category/edit/{id}', [SubCategoryController::class, 'edit'])->name('sub-category-edit');
    Route::get('/sub-category/delete/{id}', [SubCategoryController::class, 'remove'])->name('sub-category-delete');
    Route::post("/sub-category/status/{id}", [SubCategoryController::class, "changeStatus"])->name("subcategory-status");

    // Items module
    Route::get('/items',[ItemsController::class,'index'])->name('items-index');
    Route::post('/items/store',[ItemsController::class,'store'])->name('items-store');
    Route::post('/items/subitem/store',[ItemsController::class,'storesubitem'])->name('items-subitem-store');
    Route::post('/items-type/store',[ItemsController::class,'itemtypestore'])->name('items.type.store');
    Route::post('/update-item-pricing', [ItemsController::class, 'updateItemPricing'])->name('update.item.pricing');
    Route::get('/items/edit/{id}/{id1?}', [ItemsController::class, 'edit'])->name('items-edit');
    Route::get('/items/delete/{id}', [ItemsController::class, 'remove'])->name('items-delete');
    Route::post("/items/status/{id}", [ItemsController::class, "changeStatus"])->name("items-status");
    Route::post("/items/get-subcategory", [ItemsController::class, "getSubCategory"])->name("get-subcategory");
    Route::post('/recurring-card/remove', [ItemsController::class, 'removerecurringcard'])->name('recurring.card.remove');

    // Coupon module
    Route::get('/coupon',[CouponController::class,'index'])->name('coupon-index');
    Route::get('/coupon-edit/{id}',[CouponController::class,'edit'])->name('coupon-edit');
    Route::get('/get-applicable-data', [CouponController::class, 'getApplicableData'])->name('get.applicable.data');
    Route::post('/coupon/store',[CouponController::class,'store'])->name('coupons.store');
    Route::get('/coupon/delete/{id}',[CouponController::class,'remove'])->name('coupon-delete');

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

    // FAQ module
    Route::get('/FAQ',[FAQController::class,'index'])->name('FAQ-index');
    Route::post('/FAQ/store',[FAQController::class,'store'])->name('FAQ-store');
    Route::get('/FAQ/edit/{id}', [FAQController::class, 'edit'])->name('FAQ-edit');
    Route::get('/FAQ/delete/{id}', [FAQController::class, 'remove'])->name('FAQ-delete');

    // Profile
    Route::get("/profile", [UserProfileController::class, "index"])->name("profile");
    Route::post("/store-user-profile", [UserProfileController::class, "store_user_profile"])->name("store-user-profile");

    // stripe payment
    Route::post('stripe-payment', [StripePaymentController::class, 'stripePost'])->name('stripe-payment-store');
    Route::get('stripe-after-payment', [StripePaymentController::class, 'stripeAfterPayment'])->name('stripe-payment-3d');

    // razorpay payment
    Route::post('razorpay-payment', [RazorpayPaymentController::class, 'store'])->name('razorpay-payment-store');
    Route::post('free-razorpay-payment', [RazorpayPaymentController::class, 'freePlanSave'])->name('razorpay-free-plan-store');

    Route::post("/payment", [PaymentController::class, "store"])->name("payment");

    // Blog module
    Route::get('/Blog-index',[BlogController::class,'index'])->name('Blog-index');
    Route::post('/Blog/store',[BlogController::class,'store'])->name('Blog-store');
    Route::get('/Blog/edit/{id}', [BlogController::class, 'edit'])->name('Blog-edit');
    Route::get('/Blog/delete/{id}', [BlogController::class, 'remove'])->name('Blog-delete');
    Route::post('/update-blog-status', [BlogController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/delete-section', [BlogController::class, 'deleteSection'])->name('deleteSection');

    // Blog_category module
    Route::get('/Blog_category-index',[BlogCategoryController::class,'index'])->name('Blog_category-index');
    Route::post('/Blog_category/store',[BlogCategoryController::class,'store'])->name('Blog_category-store');
    Route::get('/Blog_category/edit/{id}', [BlogCategoryController::class, 'edit'])->name('Blog_category-edit');
    Route::get('/Blog_category/delete/{id}', [BlogCategoryController::class, 'remove'])->name('Blog_category-delete');
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

// FAQ
Route::get('/user-faq', [FAQController::class,'user_index']
)->name('user-faq');

// Price
Route::get('/user-price', [UserController::class,'user_price']
)->name('user-price');

// Blog Details
Route::get('/blog-details/{blog_id}', [BlogController::class, 'blogDetails'])->name('blog_details');
Route::post('/blog-comment-post/{blog_id}', [BlogController::class, 'postComment'])->name('blog-comment-post');
Route::post('/share', [BlogController::class, 'sharedatastore'])->name('share.store');
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache cleared successfully";

});
