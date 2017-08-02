<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateMoyuTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_a_moyu()
    {
        $this->withExceptionHandling();

        $this->get('/moyus/create')
            ->assertRedirect('/login');

        $this->post('/moyus', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_a_moyu()
    {
        $this->signIn();

        $moyu = make('App\Moyu');

        $response = $this->post('/moyus', $moyu->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($moyu->title)
            ->assertSee($moyu->img);
    }

    /** @test */
    public function a_muyu_requires_a_title()
    {
        $this->publishMoyu(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_muyu_requires_a_img()
    {
        $this->publishMoyu(['img' => null])
            ->assertSessionHasErrors('img');
    }

    /** @test */
    public function a_muyu_requires_a_thumbnail()
    {
        $this->publishMoyu(['thumbnail' => null])
            ->assertSessionHasErrors('thumbnail');
    }

    /** @test */
    public function a_muyu_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishMoyu(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishMoyu(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishMoyu($overwrite = [])
    {
      $this->withExceptionHandling()->signIn();

      $moyu = make('App\Moyu', $overwrite);

      return $this->post('/moyus', $moyu->toArray());
    }
}
