<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Notifications\MoyuWasUpdated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MoyuTest extends TestCase
{
    use DatabaseMigrations;

    protected $moyu;

    function setUp()
    {
        parent::setUp();

        $this->moyu = create('App\Moyu');
    }

    /** @test */
    function a_moyu_can_make_a_string_path()
    {
        $moyu = create('App\Moyu');

        $this->assertEquals(
          "/moyus/{$moyu->channel->slug}/{$moyu->id}", $moyu->path()
        );
    }

    /** @test */
    function a_moyu_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->moyu->creator);
    }

    /** @test */
    function a_moyu_has_replies()
    {
       $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->moyu->replies);
    }

    /** @test */
    function a_moyu_can_add_a_reply()
    {
        $this->moyu->addReply([
          'body' => 'FooBar',
          'user_id' => 1,
        ]);

        $this->assertCount(1, $this->moyu->replies );
    }

    /** @test */
    function a_moyu_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
      Notification::fake();

      $this->signIn()
           ->moyu
           ->subscribe()
           ->addReply([
              'body' => 'FooBar',
              'user_id' => 999,
            ]);

      Notification::assertSentTo(auth()->user(), MoyuWasUpdated::class);
    }

    /** @test */
    function a_moyu_belongs_to_a_channel()
    {
        $moyu = create('App\Moyu');

        $this->assertInstanceOf('App\Channel', $moyu->channel);
    }

    /** @test */
    function a_moyu_can_be_subscribed_to()
    {
      $moyu = create('App\Moyu');

      $moyu->subscribe($userId = 1);

      $this->assertEquals(
        1,
        $moyu->subscriptions()->where('user_id', $userId)->count()
      );
    }

    /** @test */
    function a_moyu_can_be_unsubscribed_from()
    {
      $moyu = create('App\Moyu');

      $moyu->subscribe($userId = 1);

      $moyu->unsubscribe($userId);

      $this->assertCount(0, $moyu->subscriptions);
    }

    /** @test */
    function it_knows_if_an_authenticated_user_is_subscribed_to_it()
    {
      $moyu = create('App\Moyu');

      $this->signIn();

      $this->assertFalse($moyu->isSubscribedTo);

      $moyu->subscribe();

      $this->assertTrue($moyu->isSubscribedTo);
    }

    /** @test */
    function a_moyu_can_check_if_the_authenticated_user_has_read_it()
    {
      $this->signIn();

      $moyu = create('App\Moyu');

      $this->assertTrue($moyu->hasUpdatesFor(auth()->user()));

      auth()->user()->read($moyu);

      $this->assertFalse($moyu->hasUpdatesFor(auth()->user()));
    }
}
