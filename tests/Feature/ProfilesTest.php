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
    public function profiles_display_all_moyus_created_by_the_associated_user()
    {
      $user = create('App\User');

      $moyu = create('App\Moyu', ['user_id' => $user->id]);

      $this->get("/profiles/$user->name")
           ->assertSee($moyu->title);
    }
}
