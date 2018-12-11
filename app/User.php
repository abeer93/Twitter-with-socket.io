<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User Class responsible for users operations.
 * @package App
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class User extends Authenticatable
{
    /**
     * Use laravel notifiable trait
     */
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get tweets belongs to user
     */
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    /**
     * Get user followers
     */
    public function followers() 
    {
        return $this->belongsToMany(self::class, 'follows', 'followee_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get users which user already follow
     */
    public function follows() 
    {
        return $this->belongsToMany(self::class, 'follows', 'user_id', 'followee_id')
                    ->withTimestamps();
    }

    /**
     * Check if user follow other user
     */
    public function isFollowing($followee_id)
    {
        return (bool) $this->follows()->where('followee_id', $followee_id)->first(['follows.id']);
    }

    /**
     * Follow user
     */
    public function follow($userId) 
    {
        $this->follows()->attach($userId);
        return $this;
    }

    /**
     * Un-follow user 
     */
    public function unfollow($userId)
    {
        $this->follows()->detach($userId);
        return $this;
    }
}
