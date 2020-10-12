<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Author extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // 'authorName' => $author_resource->name,
        //     'quoteLink' => $this->link,
        //     'quoteparkAuthorLink' => $author_resource->link,
        //     'wikiquoteAuthorLink' => $author_resource->wikiquote_link,
        return [
            'authorName' => $this->name,
            'quoteparkAuthorLink' => $this->link,
            'wikiquoteAuthorLink' => $this->wikiquote_link,
        ];
    }
}
