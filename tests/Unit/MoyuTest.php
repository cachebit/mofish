<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MoyuTest extends TestCase
{
    use DatabaseMigrations;

    protected $moyu;

    public function setUp()
    {
        parent::setUp();

        $this->moyu = factory('App\Moyu')->create();
    }

    /** @test */
    public function a_moyu_has_replies()
    {
       $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->moyu->replies);
    }

    /** @test */
    public function a_moyu_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->moyu->creator);
    }

    /** @test */
    public function a_moyu_can_add_a_reply()
    {
        $this->moyu->addReply([
          'body' => 'FooBar',
          'user_id' => 1,
        ]);

        $this->assertCount(1, $this->moyu->replies );
    }
}
