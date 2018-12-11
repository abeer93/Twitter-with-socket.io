<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tweet;

/**
 * Favorite Class responsible for Favorite tweets operations.
 * @package App
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class Favorite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'tweet_id'];

    /**
     * get tweet.
     */
    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }

    /**
     * get user which favorite the tweet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
