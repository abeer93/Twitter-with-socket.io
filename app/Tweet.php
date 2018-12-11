<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Tweet Class responsible for tweets operations.
 * @package App
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class Tweet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'description'
    ];

    /**
     * get user (which create the tweet) object details.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get user likes on tweet
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
