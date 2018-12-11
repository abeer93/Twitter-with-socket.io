<?php

namespace App\Http\Controllers;

use App\User;
use App\Follow;
use Auth;
use Illuminate\Http\Request;

/**
 * FollowController Class handle followers requests to follow and unfollow different users.
 * @package App\Http\Controllers
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class FollowController extends Controller
{
    /**
     * Make user follow other users
     * 
     * @param int $followeeId represent user id which logged user need to follow
     * @return view of listing all users and display if current user follow them or not
     */
    public function follow($followeeId)
    {
        $follower = Auth::user();
        $followee = User::find($followeeId);
        if(!$follower->isFollowing($followee->id)) {
            $follower->follow($followee->id);
            return back()->withSuccess("You are now friends with {$followee->name}");
        }
        return back()->withError("You are already following {$followee->name}");

    }

    /**
     * Unfollow users
     * 
     * @param int $followeeId represent user id which logged user need to un-follow
     * @return view of listing all users and display if current user follow them or not
     */
    public function unfollow($followeeId)
    {
        $follower = Auth::user();
        $followee = User::find($followeeId);
        if($follower->isFollowing($followee->id)) {
            $follower->unfollow($followee->id);
            return back()->withSuccess("You are no longer friends with {$followee->name}");
        }
        return back()->withError("You are not following {$followee->name}");
    }
    
}
