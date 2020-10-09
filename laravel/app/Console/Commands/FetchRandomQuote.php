<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\API\RapidApiRequest;

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
        // fetch random quote from Rapid API endpoint
        $response = $request->fetchRandomQuote();

        $this->info($response->body());

        // todo
        // - check if quote is unique in db
        // if unique, insert - otherwise, repeat fetch/check/insert.
        
    }
}
