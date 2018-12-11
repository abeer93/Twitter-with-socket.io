<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Auth;
use App\Favorite;
use App\User;
use App\Tweet;

/**
 * TweetController Class handle requests for tweets favorite.
 * @package App\Http\Controllers
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class FavoriteController extends Controller
{
    /**
     * Make user favorite tweet
     */
    public function favorite(Request $request) 
    {
        if($request->ajax() && $request->isMethod('post')) {
            $createdFavorite = Favorite::create([
                'user_id'  => $request->input('userId'),
                'tweet_id' => $request->input('tweetId')
            ]);
            // count number of favorites over tweet
            $favoritesOverTweet = Favorite::where('tweet_id', $createdFavorite->tweet->id)->count();
            return Response::json([
                'success' => true,
                'countFavoritesOverTweet' => $favoritesOverTweet,
            ]);
        }
    }

    /**
     * Unfavorite tweet
     */
    public function unfavorite(Request $request)
    {
        if($request->ajax() && $request->isMethod('delete')) {
            $tweet_id = $request->input('tweetId');
            $user_id = $request->input('userId');
            $favorite = Favorite::where('tweet_id', $tweet_id)->where('user_id', $user_id)->delete();
            // count number of favorites over tweet
            $favoritesOverTweet = Favorite::where('tweet_id', $tweet_id)->count();
            return Response::json([
                'success' => true,
                'countFavoritesOverTweet' => $favoritesOverTweet,
            ]);
        }
    }
}
