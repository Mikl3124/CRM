<?php

use App\Models\Pay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\InteractionController;

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

//Customers

Auth::routes();

Route::post('access', [HomeController::class, 'access'])->name('access');
Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

//Customers
Route::get('/customer/create', [CustomerController::class, 'create'])->middleware(['auth'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->middleware(['auth'])->name('customer.store');
Route::get('/customer/show/{id}', [CustomerController::class, 'show'])->middleware(['auth'])->name('customer.show');
Route::post('/customer/delete', [CustomerController::class, 'delete'])->middleware(['auth'])->name('customer.delete');

//Projects
Route::get('/project/create/{id}', [ProjectController::class, 'create'])->middleware(['auth'])->name('project.create');
Route::post('/project/store', [ProjectController::class, 'store'])->middleware(['auth'])->name('project.store');
Route::get('/project/list/{id}', [ProjectController::class, 'list'])->middleware(['auth'])->name('projects.list');
Route::get('/project/show/{id}', [ProjectController::class, 'show'])->middleware(['auth'])->name('project.show');
Route::post('/project/delete', [ProjectController::class, 'delete'])->middleware(['auth'])->name('project.delete');

//Quotes
Route::get('/quote/create/{id}', [QuoteController::class, 'create'])->middleware(['auth'])->name('quote.create');
Route::post('/quote/store', [QuoteController::class, 'store'])->middleware(['auth'])->name('quote.store');
Route::get('/quote/show/{token}', [QuoteController::class, 'show'])->name('quote.show');
Route::post('/quote/create-acount', [QuoteController::class, 'createAcount'])->middleware(['auth'])->name('create.acount');
Route::post('/quote/delete', [QuoteController::class, 'delete'])->middleware(['auth'])->name('quote.delete');

//AVP
Route::get('/avp/create/{id}', [AvpController::class, 'create'])->middleware(['auth'])->name('avp.create');
Route::post('/avp/store', [AvpController::class, 'store'])->middleware(['auth'])->name('avp.store');
Route::get('/avp/show/{token}', [AvpController::class, 'show'])->name('avp.show');
Route::post('/download-avp/', [AvpController::class, 'download'])->name('download-avp');
Route::post('/avp/delete', [AvpController::class, 'delete'])->middleware(['auth'])->name('avp.delete');

//Payment
Route::post('/quote-secure-paiement', [PaiementController::class, 'createQuotePayement'])->name('createQuotePayement');
Route::post('/avp-secure-paiement', [PaiementController::class, 'createAvpPayement'])->name('createAvpPayement');
Route::post('/payment-quote-success', [PaiementController::class, 'successQuote'])->name('success-quote');
Route::post('/payment-avp-success', [PaiementController::class, 'successAvp'])->name('success-avp');

//Interactions
Route::post('/interaction/store', [InteractionController::class, 'store'])->name('interaction.store');
Route::get('/interactions/list/{id}', [InteractionController::class, 'list'])->middleware(['auth'])->name('interactions.list');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
