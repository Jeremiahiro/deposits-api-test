<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// API route for login
Route::post('/login', [AuthController::class, 'login']);
// API route for registration 
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // API route for current user
	Route::get('/user', [UserController::class, 'user']);

	// Admin Endpoints 
	Route::group(['middleware' => ['role:admin'], 'prefix'=>'admin'], function () {
		// API route for all users
		Route::get('/users', [UserController::class, 'index']);
		// API route for single users
		Route::get('/user/{id}', [UserController::class, 'show']);
		// API route for users based on date of registration
		Route::get('/user/{id}', [UserController::class, 'show']);
		// API route for users who logged in today
		Route::get('/users/today', [UserController::class, 'today']);
		// API route for users based on date of registration
		Route::get('/users/registered-on', [UserController::class, 'date_of_registration']);
	});

    // API route for logout user
	Route::post('/logout', [AuthController::class, 'logout']);
});