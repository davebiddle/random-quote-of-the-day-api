<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Quote;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(Quote::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function latest()
    {
        return response()->json(Quote::latest()->with('author')->first());
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
