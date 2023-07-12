<?php
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('/toppings', [ToppingController::class, 'index']);
// Route::post('/toppings', [ToppingController::class, 'store']);

Route::resource('toppings', ToppingController::class);

Route::get('/toppings/search/{name}', [ToppingController::class, 'search']);

Route::resource('orders', OrderController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
