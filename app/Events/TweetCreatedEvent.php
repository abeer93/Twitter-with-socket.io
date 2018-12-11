<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Tweet;

/**
 * TweetCreatedEvent Class event handle new creation of new tweets
 * @package App\Events
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class TweetCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Tweet $tweet instane of Tweet
     */
    public $tweet;

    /**
     * array $followers array contain user's (who create the tweet) followers
     */
    public $followers;

    /**
     * Create a new event instance.
     *
     * @param Tweet $tweet tweet instance
     * @return void
     */
    public function __construct(Tweet $tweet, array $followers)
    {
        $this->tweet = $tweet;
        $this->followers = $followers;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('tweet-created');
    }
}
