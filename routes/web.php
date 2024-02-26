<?php

use Illuminate\Support\Facades\Route;




use App\Http\Controllers\User\UserController;
use App\Http\Controllers\role\RoleController;
use App\Http\Controllers\ProfileSettings\ProfileSettingsController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\SubCategory\SubCategoryController;
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
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
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
});
