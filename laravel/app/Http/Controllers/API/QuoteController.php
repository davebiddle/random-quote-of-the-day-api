<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Quote;
use App\Http\Resources\Quote as QuoteResource;
use App\Http\Resources\PreviousQuoteCollection;

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
    public function index(Request $request)
    {
        $per_page = $request->query('per_page', 10);
        $order_by = $request->query('order', 'desc');

        return new PreviousQuoteCollection(
            Quote::orderBy('created_at', $order_by)
                ->previous(0)
                ->paginate($per_page)
        );
    }

    /**
     * Return the latest quote in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function latest()
    {
        return new QuoteResource(Quote::latest()->first());
    }

    /**
     * Return the specified number of latest quotes,
     * starting from the second latest quote.
     *
     * @return \Illuminate\Http\Response
     */
    public function previous($limit)
    {
        return QuoteResource::collection(Quote::previous($limit)->get());
    }
}
