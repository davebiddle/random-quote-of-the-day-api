<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Quote;

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

Route::get('/quotes', 'API\QuoteController@index');

Route::get('/quotes/latest', 'API\QuoteController@latest');

Route::get('/quotes/previous', 'API\QuoteController@previous');
