<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInFroumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_can_not_participate_in_moyu()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/moyus/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_can_paticipate_in_moyu()
    {
        $this->be($user = factory('App\User')->create());

        $moyu = factory('App\Moyu')->create();

        $reply = factory('App\Reply')->make();
        $this->post($moyu->path().'/replies', $reply->toArray());

        $this->get($moyu->path())
          ->assertSee($reply->body);

    }
}
