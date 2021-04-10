<?php

use App\Models\Pay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaiementController;

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
});

//Customers

Auth::routes();

Route::post('access', [HomeController::class, 'access'])->name('access');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

//Customers
Route::get('/customer/create', [CustomerController::class, 'create'])->middleware(['auth'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->middleware(['auth'])->name('customer.store');
Route::get('/customer/show/{id}', [CustomerController::class, 'show'])->middleware(['auth'])->name('customer.show');

//Projects
Route::get('/project/create/{id}', [ProjectController::class, 'create'])->middleware(['auth'])->name('project.create');
Route::post('/project/store', [ProjectController::class, 'store'])->middleware(['auth'])->name('project.store');
Route::get('/project/list/{id}', [ProjectController::class, 'list'])->middleware(['auth'])->name('projects.list');
Route::get('/project/show/{id}', [ProjectController::class, 'show'])->middleware(['auth'])->name('project.show');

//Quotes
Route::get('/quote/create/{id}', [QuoteController::class, 'create'])->middleware(['auth'])->name('quote.create');
Route::post('/quote/store', [QuoteController::class, 'store'])->middleware(['auth'])->name('quote.store');
Route::get('/quote/show/{token}', [QuoteController::class, 'show'])->name('quote.show');

//Payment
Route::post('/secure-paiement', [PaiementController::class, 'create'])->name('paiement');
Route::get('/payment-success/', [PaiementController::class, 'success'])->name('success-paiement');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
