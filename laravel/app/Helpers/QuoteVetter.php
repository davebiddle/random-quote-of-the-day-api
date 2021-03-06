<?php
namespace App\Helpers;

use Illuminate\Http\Client\Response;

class QuoteVetter
{
    /**
     * List of authors to check and reject quotes from.
     */
    protected static $authors_to_exclude = [
        'Hitler',
        'Stalin',
        'Pinochet',
        'Goebbels',
        'Rommel',
    ];

    /**
     * List of words to check for in quote content and reject quote if present.
     */
    protected static $words_to_exclude = [
        'nazi', 'hitler', 'stalin', 'pinochet', 'fuck', 'shit', 
    ];

    /**
     * Vets todays' quote response to exclude quotes with properties specified 
     * for exclusion.
     * 
     * We need to return `true` if the response fails the checks, and 
     * `false` if it passes.
     * 
     * @param Illuminate\Http\Client\Response $quote_response
     * @return bool
     */
    public static function vetQuoteResponse(Response $quote_response)
    {
        $author_name = $quote_response['originator']['name'];
        $quote_content = $quote_response['content'];

        // vet author name
        foreach (self::$authors_to_exclude as $author_to_exclude) {
            if (stristr($author_name, $author_to_exclude)) {
                return true;
            }
        }

        // vet quote content
        foreach (self::$words_to_exclude as $word) {
            if (stristr($quote_content, $word)) {
                return true;
            }
        }

        return self::checkResponseIntegrity($quote_response);
    }

    /**
     * Checks that the response array structure has all the required 
     * elements.
     * 
     * We need to return `true` if the response fails the checks, and 
     * `false` if it passes.
     * 
     * @param Illuminate\Http\Client\Response $quote_response
     * @return bool
     */
    public static function checkResponseIntegrity($quote_response)
    {
        $author = $quote_response['originator'] ?? [];
        
        if (!array_key_exists('id', $author)) {
            return true;
        }

        // todo :: further checks

        return false;
    }
}
