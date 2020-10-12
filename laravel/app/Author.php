<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'link', 'quotepark_id',
    ];

    /**
     * The accessors to append to this model's array form.
     *
     * @var array
     */
    protected $appends = [
        'wikiquote_link',
    ];

    public function quotes() {
        return $this->hasMany(Quote::class);
    }

    /**
     * Build and return a Wikiquote search link for this author.
     * eg. "https://en.wikiquote.org/w/index.php?search=Leonardo%20da%20Vinci"
     *
     * @return string
     */
    public function getWikiquoteLinkAttribute()
    {
        return sprintf(
            'https://en.wikiquote.org/w/index.php?search=%s',
            str_replace(' ', '+', $this->name)
        );
    }
}
