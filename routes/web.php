<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::view('/', 'index');

Route::get('/contact', [ContactController::class,'index'])->name('contact');
Route::post('/contact',[ContactController::class,'sendMail'])->name('contact.sendMail');
Route::get('/contact/complete', [ContactController::class,'complete'])->name('contact.complete');
