<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author as AuthorResource;

class Quote extends JsonResource
{
    /**
     * Transform the resource into an array, with keys
     * renamed and values formatted.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dateFormatted' => $this->full_formatted_date,
            'quoteContent' => $this->content,
            'author' => new AuthorResource($this->author),
            'quoteLink' => $this->link,
        ];
    }
}
