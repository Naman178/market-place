<?php

use App\Http\Controllers\Invoice\InvoiceController;
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
use App\Http\Controllers\Testimonial\TestimonialController;
use App\Http\Controllers\SocialMedia\SocialMediaController;
use App\Http\Controllers\FrontEnd\HomePage\HomePageController;
use App\Http\Controllers\FrontEnd\Checkout\CheckoutController;
use App\Http\Controllers\FrontEnd\Auth\LoginController;
use App\Http\Controllers\FrontEnd\Payment\PaymentController;
use App\Http\Controllers\Auth\CutomForgotPasswordController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserProfile\UserProfileController;
use App\Http\Controllers\Stripe\StripePaymentController;
use App\Http\Controllers\Razorpay\RazorpayPaymentController;
use App\Http\Controllers\AdminDashboard\AdminDashboardController;
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
Route::post("/newsletter-add", [HomePageController::class, "newsletter"])->name('newsletter-add');
Route::get('/newsletter/{id}',[HomePageController::class, "deletenewsletter"])->name('newsletter-delete');
// Route::get('/product/{category}', [HomePageController::class, 'Categoryshow'])->name('category.list');
Route::get('/subcategory/{subcategory}', [SubCategoryController::class, 'show'])->name('subcategory.list');
Route::get('/items/sort', [HomePageController::class, 'sortItems'])->name('items.sort');
Route::get('/category/{category}/{slug}', [HomePageController::class, 'show'])->name('product.list');
Route::get('/product-details/{id}', [HomePageController::class, 'buynow'])->name('buynow.list');
Route::post('/comments/update/{id}', [HomePageController::class, 'commentupdate'])->name('comments.update');
Route::post('/reviews/update/{id}', [HomePageController::class, 'reviewsupdate'])->name('reviews.update');
Route::post('/product-comment-post', [HomePageController::class, 'commentPost'])->name('product-comment-post');
Route::post('/product-review-post', [HomePageController::class, 'reviewPost'])->name('product-review-post');
Route::post('/wishlist/add', [HomePageController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/remove', [HomePageController::class, 'removeToWishlist'])->name('wishlist.remove');
Route::get('/get-wishlist', [HomePageController::class, 'getUserWishlist'])->name('get_wishlist');
Route::get('/wishlist', [HomePageController::class, 'wishlistindex'])->name('wishlist.index');

Route::get("/checkout/{id}", [CheckoutController::class, "index"])->name("checkout");
Route::post('/checkout/remove', [CheckoutController::class, 'removeItem'])->name('cart.remove');
Route::post('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
Route::post('/checkout/process-payment', [CheckoutController::class, "processPayment"])->name('process.payment');
Route::get("/signup", [RegisterController::class, "index"])->name("signup");
Route::get("/register", [RegisterController::class, "register"])->name("register");
Route::post("/signup/store", [RegisterController::class, "register"])->name("registerUser");
Route::get('/user-login', [LoginController::class, 'index'])->name('user-login');
Route::post('/user-post-login', [LoginController::class, 'postLogin'])->name('user-login-post');
Route::get('/user-login/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/user-login/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('auth/github', [LoginController::class, 'redirectToGitHub'])->name('github.login');
Route::get('auth/github/callback', [LoginController::class, 'handleGitHubCallback']);

Route::get('auth/linkedin', [LoginController::class, 'redirectToLinkdin'])->name('linkedin.login');
Route::get('auth/linkedin/callback', [LoginController::class, 'handleLinkdinCallback']);

// user register
Route::post('/post-registration', [RegisterController::class, 'postRegistration'])->name('user-register-post');
Route::post('/user-create-checkout', [RegisterController::class, 'userCreateCheckout'])->name('user-create-checkout');
Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent'])->name('create-payment-intent');
Route::get('/thankyou', function () { return view('Thankyou.thankyou'); })->name('thankyou');
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    //User Module
    Route::get('/user',[UserController::class,'index'])->name('user-index');
    Route::post('/user/store',[UserController::class,'store'])->name('user-store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user-edit');
    Route::get('/user/delete/{id}', [UserController::class, 'remove'])->name('user-delete');
    Route::get('/user/sendResetPassword/{email}', [UserController::class, 'sendResetPassword'])->name('user-send-reset-password');

    //Role Module
    Route::resource('roles', RoleController::class);

    //Profile Settings Module
    Route::get('/profilesettings/{id}',[ProfileSettingsController::class,'index'])->name('profilesettings');
    Route::post('/profilesettings/store',[ProfileSettingsController::class,'store'])->name('profilesettings-store');
    Route::get('/changePassword', [ProfileSettingsController::class, 'showChangePasswordGet'])->name('changePasswordGet');
    Route::post('/changePassword', [ProfileSettingsController::class, 'changePasswordPost'])->name('changePasswordPost');

    //Settings Module
    Route::get('/settings',[SettingsController::class,'index'])->name('settings-index');
    Route::post('/settings/store',[SettingsController::class,'store'])->name('settings-store');
    Route::post('/settings/mail',[SettingsController::class,'mail'])->name('settings-mail');

    // front user dashboard
    Route::get('/user-dashboard', [UserController::class, 'userDashboard'])->name('user-dashboard');
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
    Route::get('/downloads', [UserController::class, 'downloads'])->name('downloads');
    Route::get('/support', [UserController::class, 'support'])->name('support');
    Route::get('/transactions', [UserController::class, 'transactions'])->name('transactions');
    Route::get('/invoice', [UserController::class, 'invoice'])->name('invoice');
    Route::get('/subscription', [UserController::class, 'subscription'])->name('subscription');
    Route::get('/profile-settings', [UserController::class, 'settings'])->name('profile-settings');

    //invoice
    Route::get('/invoicepreview/{id}',[InvoiceController::class,'preview'])->name('invoice-preview');
    Route::get('invoice/download/{id}', [InvoiceController::class, 'downloadPdf'])->name('invoice.download');
    Route::get('/invoicelist', [InvoiceController::class, 'index'])->name('invoice-list');
    Route::get('/orderlist', [InvoiceController::class, 'viewOrder'])->name('order-list');
    Route::get('order-details/{id}', [InvoiceController::class, 'orderDetails'])->name('order-details');
    Route::get('/invoice/edit/{id}/{id1?}', [InvoiceController::class, 'edit'])->name('invoice-edit');
    Route::get('/fetch-subcategories', [InvoiceController::class, 'fetchSubcategories'])->name('fetch.subcategories');
    Route::get('/fetch-products', [InvoiceController::class, 'fetchProducts'])->name('fetch.products');
    Route::get('/fetch-coupon', [InvoiceController::class, 'fetchcoupon'])->name('fetch.coupon');
    Route::post('/invoice/store',[InvoiceController::class,'store'])->name('invoice-store');
    // Expired the key
    Route::post('/key/suspend/{id}', [InvoiceController::class, 'suspendKey'])->name('key.suspend');

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
    Route::post('/stripe/webhook', [StripePaymentController::class, 'handleWebhook']);
    Route::get('/subscription/cancel/{id}', [StripePaymentController::class, 'cancelSubscription'])->name('subscription.cancel');
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

    // Testimonial module
    Route::get('/Testimonial-index',[TestimonialController::class,'index'])->name('Testimonial-index');
    Route::post('/Testimonial/store',[TestimonialController::class,'store'])->name('Testimonial-store');
    Route::get('/Testimonial/edit/{id}', [TestimonialController::class, 'edit'])->name('Testimonial-edit');
    Route::get('/Testimonial/delete/{id}', [TestimonialController::class, 'remove'])->name('Testimonial-delete');
    
    // SocialMedia module
    Route::get('/SocialMedia-index',[SocialMediaController::class,'index'])->name('SocialMedia-index');
    Route::post('/SocialMedia/store',[SocialMediaController::class,'store'])->name('SocialMedia-store');
    Route::get('/SocialMedia/edit/{id}', [SocialMediaController::class, 'edit'])->name('SocialMedia-edit');
    Route::get('/SocialMedia/delete/{id}', [SocialMediaController::class, 'remove'])->name('SocialMedia-delete');
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
Route::get('/faq', [FAQController::class,'user_index']
)->name('user-faq');

// Price
Route::get('/user-price', [UserController::class,'user_price']
)->name('user-price');

// categpry
Route::get('/category/{slug}', [CategoryController::class, 'categoryDetails'])->name('category_details');

// Blog Details
Route::get('/blogs/{category}/{slug}', [BlogController::class, 'blogDetails'])->name('blog_details');
Route::get('/blogs', [BlogController::class, 'blogIndex'])->name('blog-index');
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
