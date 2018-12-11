<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;
use App\Tweet;
use Auth;

/**
 * UserController Class handle users requests and user notifications requests.
 * @package App\Http\Controllers
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class UserController extends Controller
{
    /**
     * List all user exist in the system except the logged one
     * 
     * @return view html display alll users
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::where('id', '!=', Auth::id())->get()
        ]);
    }
}
