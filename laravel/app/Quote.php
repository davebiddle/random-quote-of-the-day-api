<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quotepark_id', 'content', 'link', 'author_id', 'created_at'
    ];

    public function author() {
        return $this->hasOne(Author::class);
    }
}
