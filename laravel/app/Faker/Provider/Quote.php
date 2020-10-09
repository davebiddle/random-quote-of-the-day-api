<?php

namespace App\Faker\Provider;

use Faker\Provider\Base as BaseProvider;
use Faker\Generator;

class Quote extends BaseProvider
{
    protected $quotes = [
        [
            'quotepark_id' => 5507,
            'content' => "Here is my secret. It is very simple. It is only with the heart that one can see rightly; What is essential is invisible to the eye.",
            'link' => "https://quotepark.com/quotes/5507-antoine-de-saint-exupery-here-is-my-secret-it-is-very-simple-it-is-only-w/",
            'author' => [
                'quotepark_id' => '164808',
                'name' => 'Antoine de Saint-Exupéry',
                'link' => 'https://quotepark.com/authors/antoine-de-saint-exupery/',
            ],
        ],
        [
            'quotepark_id' => 1500482,
            'content' => "Everything here is edible; even I'm edible. But that, dear children, is cannibalism, and is in fact frowned upon in most societies.",
            'link' => "https://quotepark.com/quotes/1500482-johnny-depp-everything-here-is-edible-even-im-edible-but-th/",
            'author' => [
                'quotepark_id' => 132838,
                'name' => 'Johnny Depp',
                'link' => 'https://quotepark.com/authors/johnny-depp/',
            ],
        ],
        [
            'quotepark_id' => 1787399,
            'content' => "We live in a world where the funeral matters more than the dead, the wedding more than love and the physical rather than the intellect. We live in the container culture, which despises the content.",
            'link' => "https://quotepark.com/quotes/1787399-eduardo-galeano-we-live-in-a-world-where-the-funeral-matters-more/",
            'author' => [
                'quotepark_id' => '214251',
                'name' => 'Eduardo Galeano',
                'link' => 'https://quotepark.com/authors/eduardo-galeano/',
            ],
        ],
        [
            'quotepark_id' => 1075918,
            'content' => "I’m not in this world to live up to your expectations and you’re not in this world to live up to mine.",
            'link' => "https://quotepark.com/quotes/1075918-bruce-lee-im-not-in-this-world-to-live-up-to-your-expectati/",
            'author' => [
                'quotepark_id' => '128481',
                'name' => 'Bruce Lee',
                'link' => 'https://quotepark.com/authors/bruce-lee/',
            ],
        ],
        [
            'quotepark_id' => 1483327,
            'content' => "When I know your soul, I will paint your eyes",
            'link' => "https://quotepark.com/quotes/1483327-amedeo-modigliani-when-i-know-your-soul-i-will-paint-your-eyes/",
            'author' => [
                'quotepark_id' => '143674',
                'name' => 'Amedeo Modigliani',
                'link' => 'https://quotepark.com/authors/amedeo-modigliani/',
            ],
        ],
        [
            'quotepark_id' => 1855314,
            'content' => "If you can make it through the night, there's a brighter day.",
            'link' => "https://quotepark.com/quotes/928673-tupac-shakur-if-you-can-make-it-through-the-night-theres-a-br/",
            'author' => [
                'quotepark_id' => '129929',
                'name' => 'Tupac Shakur',
                'link' => 'https://quotepark.com/authors/tupac-shakur/',
            ],
        ],
        [
            'quotepark_id' => 909766,
            'content' => "Tell me how you read and I'll tell you who you are.",
            'link' => "https://quotepark.com/quotes/909766-martin-heidegger-tell-me-how-you-read-and-ill-tell-you-who-you-are/",
            'author' => [
                'quotepark_id' => '128474',
                'name' => 'Martin Heidegger',
                'link' => 'https://quotepark.com/authors/martin-heidegger/',
            ],
        ]
    ];
    
    protected $current_quote;

    public function __construct(Generator $generator) 
    {
        parent::__construct($generator);

        $this->setCurrentQuote();
    }

    public function setCurrentQuote()
    {
        $this->current_quote = $this->randomElement($this->quotes);
    }

    public function quoteparkId()
    {
        return $this->current_quote['quotepark_id'];
    }

    public function content()
    {
        return $this->current_quote['content'];
    }

    public function link()
    {
        return $this->current_quote['link'];
    }

    public function authorQuoteparkId()
    {
        return $this->current_quote['author']['quotepark_id'];
    }
    public function authorName()
    {
        return $this->current_quote['author']['name'];
    }

    public function authorLink()
    {
        return $this->current_quote['author']['link'];
    }
}