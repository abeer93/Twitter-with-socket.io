<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Auth;
use App\User;
use App\Tweet;
use App\Events\TweetCreatedEvent;

/**
 * TweetController Class handle tweets request which implement CRUD operation over tweets.
 * @package App\Http\Controllers
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class TweetController extends Controller
{
    /**
     * List latest tweets and paginate it with only 10 tweets in page
     * 
     * @return view html view which display tweets
     */
    public function index()
    {
        $tweets = Tweet::latest()->paginate(10);
        $loggedUser = Auth::user();
        // check tweets liked by logged user
        foreach($tweets as $tweet) {
            foreach($tweet->favorites as $favorite) {
                if($favorite->user->id == $loggedUser->id) {
                    $tweet->liked = true;
                } else {
                    $tweet->liked = false;
                }
            }
            // count number of favorites over tweet
            $tweet->FavsNum = $tweet->favorites->count();
        }
        
        return view('tweets.index', compact('tweets'));
    }

    /**
     * Display Tweet 
     * 
     * @param int $id represent tweet id
     * @return view html view display tweet data
     */
    public function show(Request $request, int $id)
    {
        // get tweet data
        $tweet = Tweet::findOrFail($id);
        // check if request is ajax
        if($request->ajax()) {
            $tweetData = [
                'id' => $tweet->id,
                'title' => $tweet->title,
                'description' => $tweet->description
            ];
            // respond to ajax with json array contain old tweet data
            return Response::json($tweetData);
        } 
        return view('tweets.show', compact('tweet'));
    }

    /**
     * Display form for creating new tweet
     * 
     * @return view containg tweet form
     */
    public function create()
    {
        return view('tweets.create');
    }

    /***
     * Store new tweet
     * 
     * @param Request $request request object to read all request data and insert new tweet
     * @return view list all tweets
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|max:255',
            'description'  => 'required'
        ]);

        $tweet = Tweet::create([
            'title'     => $request->input('title'),
            'description' => $request->input('description'),
            'user_id'   => Auth::user()->id,
        ]);

        // fire event tweet created
        event(new TweetCreatedEvent($tweet, $this->loggedUserFollowersIDs()));

        return redirect('/tweets')->with('status', 'tweet was created successfully');
    }

    /**
     * Update Tweet
     * 
     * @param Request $request http request instance
     */
    public function update(Request $request, int $id)
    {
        if($request->ajax() && $request->isMethod('put')) {
            $tweet = Tweet::find($id);
            $tweet->title       = $request->input('title');
            $tweet->description = $request->input('description');
            $tweet->save();

            return Response::json([
                    'success' => true,
                    'title' => $tweet->title,
                    'description' => $tweet->description
                ]);
        }
        return back()->withError("This Route is not valid");
    }

    /**
     * Delete tweet
     * 
     * @param int $id represent tweet id
     * @return view list all tweets
     */
    public function destroy($id)
    {
        Tweet::destroy($id);
        return redirect('/tweets')->with('success', 'Tweet was deleted');
    }

    /**
     * Get logged user followers IDs in array
     */
    private function loggedUserFollowersIDs() : array
    {
        $loggedUser = Auth::user();
        $followersIDs = [];
        foreach($loggedUser->followers as $follower) {
            array_push($followersIDs, $follower->id);
        }

        return $followersIDs;
    }
}
