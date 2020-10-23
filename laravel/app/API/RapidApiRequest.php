<?php

namespace App\API;

use Illuminate\Support\Facades\Http;

class RapidApiRequest
{
    /**
     * Fetches a random quote from the Rapid API endpoint.
     */
    public function fetchRandomQuote()
    {
        try {
            $response = Http::withHeaders([
                'x-rapidapi-host' => config('services.rapid_api.host'),
                'x-rapidapi-key' => config('services.rapid_api.key'),
            ])
                ->get(config('services.rapid_api.endpoint'))
                ->throw();
        } catch (Illuminate\Http\Client\RequestException $exception) {
            if (strstr($exception->getMessage(), '429')) { // too many requests
                sleep(60);

                $this->fetchRandomQuote;
            }
        }

        return $response;
    }
}