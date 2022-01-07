<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Carbon\Carbon;

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
        $this->middleware('auth:api', ['except' => [
            'index',
            'latest',
            'previous',
            'fetchTodaysRandomQuote',
            'refreshQuoteForDate',
            'deleteQuoteForDate',
            'deleteQuotebyDate',
        ]]);
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
            Quote::previous()
                ->orderBy('created_at', $order_by)
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
        return QuoteResource::collection(
            Quote::previous()->limit($limit)->orderBy('created_at', 'desc')->get()
        );
    }

    /**
     * Called by cron-job.org for fetching today's random quote 
     * from the RapidAPI endpoint and storing in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchTodaysRandomQuote()
    {
        $this->setIndefiniteCmd();

        return ['status' => Artisan::call('rapidapi:fetch') > 0 ? 'error' : 'success'];
    }

    /**
     * Administrative endpoint for fetching a quote for a specific 
     * date. Useful in cases when a cron hasn't set Today's Quote 
     * for over a day, for any reason.
     * 
     * @param string $date Date in the (PHP) format: Y-m-d
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchRandomQuoteForDate($date)
    {
        $this->setIndefiniteCmd();

        // format passed in date
        $date = date('Y-m-d H:i:s', strtotime($date));

        return ['status' => Artisan::call('rapidapi:fetch', [
            'created_date' => $date
        ]) > 0 ? 'error' : 'success'];
    }

    /**
     * Administrative endpoint for refreshing a quote for a specific 
     * date.
     * 
     * @param string $date Date in the (PHP) format: Y-m-d
     *
     * @return \Illuminate\Http\Response
     */
    public function refreshQuoteForDate($date)
    {
        if ($this->deleteQuotebyDate($date)) {

            $this->setIndefiniteCmd();

            return ['status' => Artisan::call('rapidapi:fetch', [
                'created_date' => $date
            ]) > 0 ? 'error' : 'success'];
        }

        return ['status' => 'error'];
    }

    /**
     * Administrative endpoint for deleting a quote for a specific 
     * date.
     * 
     * @param string $date Date in the (PHP) format: Y-m-d
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteQuoteForDate($date)
    {
        return ['status' => $this->deleteQuotebyDate($date) ? 'success' : 'error'];
    }

    /**
     * Internal method for deleting a quote for a specific 
     * date, along with related author if appropriate, and tags.
     * 
     * @param string $date Date in the (PHP) format: Y-m-d
     *
     * @return bool
     */
    protected function deleteQuotebyDate($date)
    {
        $startOfDay = new Carbon($date);
        $endOfDay = new Carbon($date);

        $quote = Quote::whereBetween('created_at', [
            $startOfDay->startOfDay(), 
            $endOfDay->endOfDay(),
        ])->first();

        if ($quote instanceof Quote) {
            $author = $quote->author()->first();

            $quote->tags()->delete();
            $quote->delete();

            // does the author have any quotes now that we've deleted this quote?
            if (!$author->quotes()->exists()) {
                // if not, we can delete the author
                $author->delete();
            }

            return true;
        }

        return false;
    }

    /**
     * Allow console command to continue until finished
     * after request disconnection, which apparently happens
     * at 30 seconds after the request is made.
     * 
     * https://cron-job.org/en/faq/
     */
    protected function setIndefiniteCmd()
    {
        ignore_user_abort(true);
    }
}
