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

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $moyu->fresh()->replies_count);
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

    /** @test */
    function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
             ->delete("/replies/{$reply->id}")
             ->assertStatus(403);

    }

    /** @test */
    public function authorized_user_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $id = $reply->id;

        $this->assertDatabaseMissing('replies', ['id' => $id]);
        $this->assertEquals(0, $reply->moyu->fresh()->replies_count);
    }

    /** @test */
    function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
             ->patch("/replies/{$reply->id}")
             ->assertStatus(403);

    }

    /** @test */
    public function authorized_user_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $id = $reply->id;
        $updatedReply = "You have been changed, fool.";

        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $id, 'body' => $updatedReply ]);
    }

    /** @test */
    function replies_that_contain_spam_may_not_be_created()
    {
      $this->signIn();

      $moyu = create('App\Moyu');
      $reply = make('App\Reply', [
        'body' => 'Yahoo customer support'
      ]);

      $this->expectException(\Exception::class);

      $this->post($moyu->path().'/replies', $reply->toArray());
    }
}
