<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quote_id', 'content',
    ];

    public function quote() {
        return $this->belongsTo(Quote::class);
    }
}
