<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_has_a_profile()
    {
        $user = create('App\User');

        $this->get("/profiles/$user->name")
             ->assertSee($user->name);
    }

    /** @test */
    function profiles_display_all_moyus_created_by_the_associated_user()
    {
      $this->signIn();

      $moyu = create('App\Moyu', ['user_id' => auth()->id()]);

      $this->get("/profiles/" . auth()->user()->name)
           ->assertSee($moyu->title);
    }
}
