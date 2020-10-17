<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Quote extends Model
{
    /**
     * The accessors to append to this model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_formatted_date',
        'short_formatted_date',
        'excerpt',
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
        return $this->belongsTo('App\Author');
    }

    public function tags() {
        return $this->hasMany('App\Tag');
    }

    /**
     * Scope a query to only include quotes older than 
     * today's quote.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrevious($query)
    {
        $today = new Carbon();

        return $query->where('created_at', '<', $today->startOfDay());
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

    /**
     * Get this Quote's excerpt, with quote characters.
     * eg. "The variety of colour in objects cannot be...".
     * 
     * Note: &hellip; is not used for the ellipsis because
     * our React frontend does escaping by default anyway.
     *
     * @return string
     */
    public function getExcerptAttribute()
    {
        return sprintf('"%s..."', mb_substr($this->content, 0, 40));
    }
}
