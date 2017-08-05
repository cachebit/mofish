<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInFroumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_user_can_not_participate_in_moyu()
    {
        $this->withExceptionHandling()
            ->post('/moyus/channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_paticipate_in_moyu()
    {
        $this->signIn();

        $moyu = create('App\Moyu');

        $reply = make('App\Reply');
        $this->post($moyu->path().'/replies', $reply->toArray());

        $this->get($moyu->path())
          ->assertSee($reply->body);

    }

    /** @test */
    function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $moyu = create('App\Moyu');

        $reply = make('App\Reply', ['body' => null]);
        $this->post($moyu->path().'/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
