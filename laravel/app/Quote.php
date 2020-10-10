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
        return $this->belongsTo(Author::class);
    }

    /**
     * Scope a query to only include the three latest quotes,
     * starting from the second latest quote.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrevious($query, $limit = 0)
    {
        return $query->orderBy('created_at', 'desc')
            ->offset(1)
            ->limit($limit);
    }
}
