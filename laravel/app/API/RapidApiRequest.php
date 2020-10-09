<?php

namespace App\API;

use Illuminate\Support\Facades\Http;

class RapidApiRequest
{
    // todo : move to env?
    const RAPID_API_HEADERS = [
        'x-rapidapi-host' => 'quotes15.p.rapidapi.com',
        'x-rapidapi-key' => '2fe657b3a8msh5238b5ce0aabaf4p1dde79jsn03afc4219014'
    ];
    const RAPID_API_ENDPOINT = 'https://quotes15.p.rapidapi.com/quotes/random/?language_code=en';

    public function fetchRandomQuote()
    {
        $response = Http::withHeaders(self::RAPID_API_HEADERS)
            ->get(self::RAPID_API_ENDPOINT)
            ->throw();

        return $response;
    }
}