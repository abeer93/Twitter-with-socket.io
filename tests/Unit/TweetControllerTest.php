<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use App\Tweet;

/**
 * TweetControllerTest Class make test cases to test @see TweetController::class.
 * @package Tests\Unit
 * @author Abeer Elhout <abeer.elhout@gmail.com>
 */
class TweetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUnAuthenticatedUsersCantHitAnyURLS()
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Unauthenticated.');
        $this->get(route('tweets.index'));
    }

    public function testGettingLastTenTweets()
    {
        // check that database is empty before test
        $this->assertEquals(0, Tweet::count());
        // craete new 10 tweets into DB
        $tweets = factory(Tweet::class, 10)->create([
            'user_id' => $this->user->id
        ]);
        $response = $this->actingAs($this->user)->get(route('tweets.index'));
        // test returned response
        $response->assertStatus(200)
            ->assertViewHas('tweets')
            ->assertViewIs('tweets.index');
        // test DB has 10 tweets
        $this->assertEquals(10, Tweet::count());
    }

    public function testTweetsPaginationReturnSecondTenTweetsWhenPageParamsEqualToTwo()
    {
        $this->assertEquals(0, Tweet::count());
        // craete new 10 tweets into DB
        $tweets = factory(Tweet::class, 16)->create([
            'user_id' => $this->user->id
        ]);
        // hit the tweets index to get the second page
        $response = $this->actingAs($this->user)->get('/tweets?page=2');
        // check response status is correct
        $response->assertStatus(200)
        ->assertViewHas('tweets')
        ->assertViewIs('tweets.index');
        // get the data returned with the view
        $tweetsOnView = $response->getOriginalContent()->getData();
        $this->assertEquals(6, count($tweetsOnView['tweets']));
    }

    public function testGetOneTweetAndShowItInView()
    {
        $this->assertEquals(0, Tweet::count());
        // craete new tweets into DB
        $tweet = factory(Tweet::class)->create([
            'user_id' => $this->user->id
        ]);
        
        $response = $this->actingAs($this->user)->get(route('tweets.show', $tweet->id));
        // check response status is correct
        $response->assertStatus(200)
        ->assertViewHas('tweet')
        ->assertViewIs('tweets.show');
        // get the data returned with the view
        $tweetOnView = $response->original['tweet'];
        $this->assertEquals($tweet->title, $tweetOnView->title);
        $this->assertEquals($tweet->description, $tweetOnView->description);
    }

    public function testGetOneTweetByAjaxRequest()
    {
        $this->assertEquals(0, Tweet::count());
        // create new tweets into DB
        $tweet = factory(Tweet::class)->create([
            'user_id' => $this->user->id
        ]);
    
        $response = $this->actingAs($this->user)
        ->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('GET', '/tweets/' . $tweet->id);

        // check response status is correct
        $response->assertStatus(200)
            ->assertJson(
                [
                    'id' => $tweet->id,
                    'title' => $tweet->title,
                    'description' => $tweet->description
                    
                ])
            ->assertJsonCount(3);
    }

    public function testCreateMethodDisplayCreateForm()
    {
        $response = $this->actingAs($this->user)->get(route('tweets.create'));
        // check response status is correct
        $response->assertStatus(200)
        ->assertViewIs('tweets.create')
        ->assertSee('title')
        ->assertSee('description');
    }

    public function testStoreWithValidData()
    {
        $data = [
            'title' => $this->faker->title,
            'description' => $this->faker->paragraph
        ];
        // send request to store data
        $response = $this->actingAs($this->user)->post(route('tweets.store'), $data);
        // test returned response
        $response->assertStatus(302)
            ->assertRedirect(route('tweets.index'))
            ->assertSessionHas('status', 'tweet was created successfully');
        // test DB has one tweet
        $this->assertEquals(1, Tweet::count());
    }

    public function testStoreWithoutSendingRequiredDataWillThrowValidationException()
    {
        $data = [
            'title' => $this->faker->title
        ];
        // expect exception as the validation will fail
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The given data was invalid.');
        // send request to store data
        $response = $this->actingAs($this->user)->post(route('tweets.store'), $data);
    }

    public function testUpdate()
    {
        // insert new tweets into DB to use it in update
        $tweet = factory(Tweet::class)->create([
            'user_id' => $this->user->id
        ]);
        // change tweet data
        $data = [
            'title' => $this->faker->word(2, true),
            'description' => $this->faker->paragraph
        ];
        // test response
        $response = $this->actingAs($this->user)
        ->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('PUT', '/tweets/' . $tweet->id, $data);

        // get the new data from DB
        $updated_tweet = $tweet->fresh();

        // check response status is correct
        $response->assertStatus(200)
            ->assertJson(
                [
                    'success' => true,
                    'title' => $updated_tweet->title,
                    'description' => $updated_tweet->description
                    
                ])
            ->assertJsonCount(3);
    }

    public function testDestroy()
    {
        // insert new tweets into DB to use it in delete
        $tweet = factory(Tweet::class)->create([
            'user_id' => $this->user->id
        ]);
        // test response
        $response = $this->actingAs($this->user)
        ->withHeaders([
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ])->json('DELETE', '/tweets/' . $tweet->id);
        // test returned response
        $response->assertStatus(302)
        ->assertRedirect(route('tweets.index'))
        ->assertSessionHas('success', 'Tweet was deleted');
        // test DB doesn't contain the deleted tweet
        $this->assertDatabaseMissing('tweets', ['id' => $tweet->id]);
        // test DB has one tweet 
        $this->assertEquals(0, Tweet::count());
    }
}
