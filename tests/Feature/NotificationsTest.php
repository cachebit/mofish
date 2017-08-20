<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_notification_is_prepared_when_a_subscribed_moyu_received_a_new_reply_that_is_not_by_the_current_user()
    {
      $this->signIn();

      $moyu = create('App\Moyu')->subscribe();

      $this->assertCount(0, auth()->user()->notifications);

      $moyu->addReply([
        'user_id' => auth()->id(),
        'body' => 'a reply has a body',
      ]);

      $this->assertCount(0, auth()->user()->fresh()->notifications);

      $moyu->addReply([
        'user_id' => create('App\User')->id,
        'body' => 'a reply has a body',
      ]);

      $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    function a_user_can_fetch_their_unread_notifications()
    {
      $this->signIn();

      $moyu = create('App\Moyu')->subscribe();

      $moyu->addReply([
        'user_id' => create('App\User')->id,
        'body' => 'a reply has a body',
      ]);

      $user = auth()->user();

      $response = $this->getJson("/profiles/{$user->name}/notifications")->json();

      $this->assertCount(1, $response);
    }

    /** @test */
    function a_user_can_mark_a_notification_as_read()
    {
      $this->signIn();

      $moyu = create('App\Moyu')->subscribe();

      $moyu->addReply([
        'user_id' => create('App\User')->id,
        'body' => 'a reply has a body',
      ]);

      $user = auth()->user();

      $this->assertCount(1, $user->unreadNotifications);

      $notificationId = $user->unreadNotifications->first()->id;

      $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

      $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
