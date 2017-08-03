<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_channel_consists_of_moyus($value='')
    {
        $channel = create('App\Channel');

        $moyu = create('App\Moyu', ['channel_id' => $channel->id]);

        $this->assertTrue($channel->moyus->contains($moyu));
    }
}
