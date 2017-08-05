<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadMoyuTest extends TestCase
{
    use DatabaseMigrations;

    protected $moyu;

    function setUp()
    {
        parent::setUp();

        $this->moyu = create('App\Moyu');
    }

    /** @test */
    function a_user_can_brower_moyus()
    {
        $this->get('/moyus')
            ->assertSee($this->moyu->title);
    }


    /** @test */
    function a_user_can_read_a_single_moyu()
    {
      $this->get($this->moyu->path())
            ->assertSee($this->moyu->title);
    }

    /** @test */
    function a_user_can_read_the_replies_of_a_moyu($value='')
    {
        $reply = create('App\Reply', ['moyu_id' => $this->moyu->id]);

        $this->get($this->moyu->path())
             ->assertSee($reply->body);
    }

    /** @test */
    function a_user_can_filter_moyus_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $moyuInChannel = create('App\Moyu', ['channel_id' => $channel->id]);
        $moyuNotInChannel = create('App\Moyu');

        $this->get('/moyus/' . $channel->slug)
            ->assertSee($moyuInChannel->title)
            ->assertDontSee($moyuNotInChannel->title);
    }

    /** @test */
    function a_user_can_filter_moyus_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'John']));

        $moyuByJohn = create('App\Moyu', ['user_id' => auth()->id()]);
        $moyuNotByJohn = create('App\Moyu');

        $this->get('/moyus?by=John')
            ->assertSee($moyuByJohn->title)
            ->assertDontSee($moyuNotByJohn->title);

    }

    /** @test */
    function a_user_can_filter_moyus_by_popularity()
    {
        $moyuWithTwoReplies = create('App\Moyu');
        create('App\Reply', ['moyu_id' => $moyuWithTwoReplies->id], 2);

        $moyuWithThreeReplies = create('App\Moyu');
        create('App\Reply', ['moyu_id' => $moyuWithThreeReplies->id], 3);

        $moyuWithNoReplies = $this->moyu;

        $response = $this->getJson('/moyus?popular=1')->json();

        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
}
