<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToMoyuTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_can_subscribe_to_moyus()
    {
      $this->signIn();

      $moyu = create('App\Moyu');

      $this->post($moyu->path() . '/subscriptions');

      $this->assertCount(1, $moyu->fresh()->subscriptions);

      
    }

    /** @test */
    function a_user_can_unsubscribe_from_moyus()
    {
      $this->signIn();

      $moyu = create('App\Moyu');

      $moyu->subscribe();

      $this->delete($moyu->path() . '/subscriptions');

      $this->assertCount(0, $moyu->subscriptions);
    }
}
