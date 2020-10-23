<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Quote;
use App\Http\Resources\Author as AuthorResource;

class PreviousQuoteListingItem extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct(Quote $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'isOpen' => false,
            'formattedDate' => $this->short_formatted_date,
            'author' => new AuthorResource($this->author),
            'quote' => [
                'excerpt' => $this->excerpt,
                'link' => $this->link,
            ],
        ];
    }
}
