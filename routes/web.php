<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\TaskWebController;
use App\Http\Controllers\AuthController;

Route::get('/', function(){ return redirect()->route('tasks.index'); });

Route::get('login', [AuthController::class,'showLogin'])->name('login');
Route::post('login', [AuthController::class,'login']);
Route::get('register', [AuthController::class,'showRegister'])->name('register');
Route::post('register', [AuthController::class,'register']);
Route::post('logout', [AuthController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function(){
    Route::resource('tasks', TaskWebController::class)->except(['show']);
});