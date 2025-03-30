<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;



Route::view('/', 'index');

Route::get('/contact', [ContactController::class,'index'])->name('contact');
Route::post('/contact',[ContactController::class,'sendMail'])->name('contact.sendMail');
Route::get('/contact/complete', [ContactController::class,'complete'])->name('contact.complete');

Route::prefix('/admin')
    ->name('admin.')
    ->group(function () {

        Route::middleware(['auth'])
            ->group(function () {
                Route::resource('/blogs',AdminBlogController::class)->except('show');
                Route::get('/users/create',[UserController::class,'create'])->name('users.create');
                Route::post('/users/store',[UserController::class,'store'])->name('users.store');
                Route::post('/logout',[AuthController::class,'logout'])->name('logout');

        });

        Route::middleware(['guest'])
            ->group(function () {
                Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
                Route::post('/login',[AuthController::class,'login']);
        });


});






