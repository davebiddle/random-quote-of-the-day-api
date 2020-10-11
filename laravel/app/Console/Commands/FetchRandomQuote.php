<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\API\RapidApiRequest;
use App\Quote;
use App\Author;

class fetchRandomQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rapidapi:fetch';

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
            $response = $request->fetchRandomQuote();

            if ($response->failed()) {
                // Todo :: notify someone somehow
            }
        } while ($response->successful() && Quote::where('quotepark_id', $response['id'])->count() > 0);

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

        $quote->save();
    }
}
