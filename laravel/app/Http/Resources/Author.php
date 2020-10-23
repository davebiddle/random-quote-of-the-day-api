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
        return [
            'authorName' => $this->name,
            'quoteparkAuthorLink' => $this->link,
            'wikiquoteAuthorLink' => $this->wikiquote_link,
        ];
    }
}
