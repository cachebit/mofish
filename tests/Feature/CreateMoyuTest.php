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

        $this->post('/moyus', raw('App\Moyu'));

        $this->assertCount(1, \App\Moyu::all());

        $moyu = \App\Moyu::first();

        $this->get($moyu->path())
            ->assertSee($moyu->title)
            ->assertSee($moyu->img);
    }
}
