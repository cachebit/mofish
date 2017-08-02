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

        $this->moyu = create('App\Moyu');
    }

    /** @test */
    public function a_moyu_can_make_a_string_path()
    {
        $moyu = create('App\Moyu');

        $this->assertEquals(
          "/moyus/{$moyu->channel->slug}/{$moyu->id}", $moyu->path()
        );
    }

    /** @test */
    public function a_moyu_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->moyu->creator);
    }

    /** @test */
    public function a_moyu_has_replies()
    {
       $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->moyu->replies);
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

    /** @test */
    public function a_moyu_belongs_to_a_channel()
    {
        $moyu = create('App\Moyu');

        $this->assertInstanceOf('App\Channel', $moyu->channel);
    }
}
