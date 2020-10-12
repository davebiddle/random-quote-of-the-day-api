<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Quote;
use App\Http\Resources\Quote as QuoteResource;

class QuoteController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * This endpoint is used for the Previous Quotes Listing,
     * so we use the 'previous' scope together with pagination
     * to retrieve the Quotes to return.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 4 quotes per page :: Todo :: 'per page' filter
        return response()->json(Quote::previous(0)->with('author')->paginate(4));
    }

    /**
     * Return the latest quote in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function latest()
    {
        return (new QuoteResource(Quote::latest()->first()))->response();
    }

    /**
     * Return the specified number of latest quotes,
     * starting from the second latest quote.
     *
     * @return \Illuminate\Http\Response
     */
    public function previous($limit)
    {
        return response()->json(Quote::previous($limit)->with('author')->get());
    }
}
