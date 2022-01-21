<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MagicController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Support\Storage\Contracts\StorageInterface;
use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('welcome');
//    \App\Models\Role::find(1)->givePermissionTo('delete users');
//    \auth()->user()->giveRolesTo('admin');
//    dd(\auth()->user()->can('delete users'));
//    auth()->user()->withDrawPermissions('delete users');
//    auth()->user()->givePermissionTo(['delete post', 'delete users']);
//    dd(auth()->user()->can('add post'));
//    auth()->user()->givRolesTo('admin', 'teacher');
//    \auth()->user()->withDrawRoles('admin');
//    $url = \Illuminate\Support\Facades\URL::temporarySignedRoute('test', now()->addMinute(1), ['id' => 12]);
//    dd($url);
})->name('home');




//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('auth.register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('auth.register');
    Route::get('login', [LoginController::class, 'show'] )->name('auth.login');
    Route::get('logout', [LoginController::class, 'logout'] )->name('auth.logout');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login.form');
    Route::get('email/send-verification', [VerificationController::class, 'send'])->name('auth.email.send.verification');
    Route::get('email/verify', [VerificationController::class, 'verifyEmail'])->name('auth.email.verify');
    Route::get('password/forget', [ForgotPasswordController::class, 'show'])->name('auth.password.forget.form');
    Route::post('password/forget', [ForgotPasswordController::class, 'sendResetLink'])->name('auth.password.forget.send');
    Route::get('password/reset', [ResetPasswordController::class, 'show'])->name('auth.password.reset.form');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('auth.password.reset');
    Route::get('redirect/{provider}' , [SocialController::class, 'redirectToProvider'])->name('auth.login.provider.redirect');
    Route::get('{provider}/callback', [SocialController::class, 'providerCallBacK'])->name('auth.login.provider.callback');
    Route::get('magic/login', [MagicController::class, 'show'])->name('auth.magic.login.form');
    Route::post('magic/login', [MagicController::class, 'sendToken'])->name('auth.magic.send.token');
    Route::get('magic/login/{token}', [MagicController::class, 'login'])->name('auth.magic.login');
    Route::get('two-factor/toggle', [TwoFactorController::class, 'show'])->name('auth.two.factor.toggle.form');
    Route::get('two-factor/activate', [TwoFactorController::class, 'activate'])->name('auth.two.factor.activate');
    Route::get('two-factor/code', [TwoFactorController::class, 'showEnterCodeForm'])->name('auth.two.factor.code.form');
    Route::post('two-factor/code', [TwoFactorController::class, 'confirmCode'])->name('auth.two.factor.code');
    Route::get('two-factor/deactivate', [TwoFactorController::class, 'deactivate'])->name('auth.two.factor.deactivate');
    Route::get('login/code', [LoginController::class, 'showCodeForm'])->name('auth.login.code.form');
    Route::post('login/code', [LoginController::class, 'confirmCode'])->name('auth.login.code');
    Route::get('two-factor/resent', [TwoFactorController::class, 'resent'])->name('auth.tow.factor.resent');

});

Route::prefix('panel')->middleware('role:manager')->group(function (){
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users/{user}/update', [UserController::class, 'update'])->name('users.update');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('roles/{role}/update', [RoleController::class, 'update'])->name('roles.update');
});

Route::get('product', [ProductController::class, 'index'])->name('product.index');

Route::get('basket/add/{product}', [BasketController::class, 'add'])->name('basket.add');
Route::get('basket', [BasketController::class, 'index'])->name('basket.index');
Route::post('basket/update/{product}', [BasketController::class, 'update'])->name('basket.update');
Route::get('basket/checkout/form', [BasketController::class, 'checkoutForm'])->name('basket.checkout.form');
Route::post('basket/checkout/form', [BasketController::class, 'checkout'])->name('basket.checkout');
Route::get('basket/clear', function (){
    resolve(StorageInterface::class)->clear();
})->name('basket.clear');
Route::post('payment/{gateway}/callback', [PaymentController::class, 'verify'])->name('payment.verify');
