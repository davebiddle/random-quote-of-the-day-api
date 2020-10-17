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

/**
 * These routes are for consumption by our React frontend.
 */
Route::get('/quotes', 'API\QuoteController@index');

Route::get('/quotes/latest', 'API\QuoteController@latest');

Route::get('/quotes/previous/{limit}', 'API\QuoteController@previous');

/**
 * These routes are administrative tasks for fetching and managing Quotes from the RapidAPI 
 * endpoint.
 */
Route::get('/quotes/fetch-todays-random-quote', 'API\QuoteController@fetchTodaysRandomQuote');

Route::get('/quotes/fetch-random-quote-for-date/{date}', 'API\QuoteController@fetchRandomQuoteForDate');

Route::get('/quotes/refresh-quote-for-date/{date}', 'API\QuoteController@refreshQuoteForDate');

Route::get('/quotes/delete-quote-for-date/{date}', 'API\QuoteController@deleteQuoteForDate');