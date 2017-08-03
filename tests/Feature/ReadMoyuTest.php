<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadMoyuTest extends TestCase
{
    use DatabaseMigrations;

    protected $moyu;

    public function setUp()
    {
        parent::setUp();

        $this->moyu = create('App\Moyu');
    }

    /** @test */
    public function a_user_can_brower_moyus()
    {
        $this->get('/moyus')
            ->assertSee($this->moyu->title);
    }


    /** @test */
    public function a_user_can_read_a_single_moyu()
    {
      $this->get($this->moyu->path())
            ->assertSee($this->moyu->title);
    }

    /** @test */
    public function a_user_can_read_the_replies_of_a_moyu($value='')
    {
        $reply = create('App\Reply', ['moyu_id' => $this->moyu->id]);

        $this->get($this->moyu->path())
             ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_moyus_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $moyuInChannel = create('App\Moyu', ['channel_id' => $channel->id]);
        $moyuNotInChannel = create('App\Moyu');

        $this->get('/moyus/' . $channel->slug)
            ->assertSee($moyuInChannel->title)
            ->assertDontSee($moyuNotInChannel->title);
    }
}
