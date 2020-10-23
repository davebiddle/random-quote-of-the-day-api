<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\API\RapidApiRequest;
use App\Helpers\QuoteVetter;
use App\Quote;
use App\Author;
use App\Tag;

class fetchRandomQuote extends Command
{
    /**
     * The name and signature of the console command.
     * 
     * The optional 'created_date' param will be used for
     * setting the 'created_at' column in the Quote model,
     * if supplied.
     *
     * @var string
     */
    protected $signature = 'rapidapi:fetch 
                            {created_date? : will be used for setting the `created_at` column in the Quote model, if supplied}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches a unique random quote from RapidAPI';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(RapidApiRequest $request)
    {
        // Fetch random quote and check if it is unique in the database. 
        // If so, insert. Otherwise, repeat fetch/check/insert.
        do {
            // The RapidAPI endpoint used for retrieving Quote data has a 
            // rate limit of 1 request per second. So let's hang around for a bit
            // before making a request.
            sleep(3); // to be on the safe side!
            
            $response = $request->fetchRandomQuote();

            if ($response->failed()) {
                // Todo :: notify someone somehow
            }
        } while (
            $response->successful() && (
            Quote::where('quotepark_id', $response['id'])->exists() ||
            QuoteVetter::vetQuoteResponse($response)
        ));

        $quote = new Quote();
        $quote->quotepark_id = $response['id'];
        $quote->content = $response['content'];
        $quote->link = $response['url'];

        // assign or insert quote's author
        $author = $response['originator'];

        $quote['author_id'] = Author::firstOrCreate(
            ['quotepark_id' => $author['id']],
            [
                'name' => $author['name'],
                'link' => $author['url'],
            ]
        )->id;

        // if a `created_date` argument has been passed, use it to set the 
        // `created_at` column in the Quote model
        $created_date = $this->argument('created_date');
        if (!empty($created_date)) {
            $quote->created_at = $created_date;
        }

        $quote->save();

        // save quote tags
        $tags = $response['tags'];

        foreach ($tags as $tag) {
            Tag::create([
                'quote_id' => $quote->id,
                'content' => $tag,
            ]);
        }
    }
}
