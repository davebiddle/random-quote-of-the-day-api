<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /**
     * The accessors to append to this model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_formatted_date',
        'short_formatted_date'
    ];

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

    /**
     * Get the Quote's full formatted date.
     * eg. "Thursday 17th September 2020"
     *
     * @return string
     */
    public function getFullFormattedDateAttribute()
    {
        return date('l jS F Y', strtotime($this->created_at));
    }

    /**
     * Get the Quote's short formatted date.
     * eg. "23rd Oct 2020"
     *
     * @return string
     */
    public function getShortFormattedDateAttribute()
    {
        return date('jS M Y', strtotime($this->created_at));
    }
}
