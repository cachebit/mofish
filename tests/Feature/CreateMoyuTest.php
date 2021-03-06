<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateMoyuTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_may_not_create_a_moyu()
    {
        $this->withExceptionHandling();

        $this->get('/moyus/create')
            ->assertRedirect('/login');

        $this->post('/moyus', [])
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_a_moyu()
    {
        $this->signIn();

        $moyu = make('App\Moyu');

        $response = $this->post('/moyus', $moyu->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($moyu->title)
            ->assertSee($moyu->img);
    }

    /** @test */
    function a_muyu_requires_a_title()
    {
        $this->publishMoyu(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_muyu_requires_a_img()
    {
        $this->publishMoyu(['img' => null])
            ->assertSessionHasErrors('img');
    }

    /** @test */
    function a_muyu_requires_a_thumbnail()
    {
        $this->publishMoyu(['thumbnail' => null])
            ->assertSessionHasErrors('thumbnail');
    }

    /** @test */
    function a_muyu_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishMoyu(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishMoyu(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    function unauthorized_users_may_not_delete_moyus()
    {
        $this->withExceptionHandling();

        $moyu = create('App\Moyu');

        $this->delete($moyu->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($moyu->path())->assertStatus(403);

    }

    /** @test */
    function authorized_users_can_delete_moyus()
    {
        $this->signIn();

        $moyu = create('App\Moyu', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['moyu_id' => $moyu->id]);

        $response = $this->json('DELETE', $moyu->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('moyus', ['id'=> $moyu->id]);
        $this->assertDatabaseMissing('replies', ['id'=> $reply->id]);

        $this->assertEquals(0, \App\Activity::count());
    }

    /** @test */
    function moyu_may_only_be_deleted_by_those_who_have_permission()
    {
        //todo
    }

    protected function publishMoyu($overwrite = [])
    {
      $this->withExceptionHandling()->signIn();

      $moyu = make('App\Moyu', $overwrite);

      return $this->post('/moyus', $moyu->toArray());
    }
}
