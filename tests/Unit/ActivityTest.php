<?php

namespace Tests\Unit;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_a_moyu_is_created()
    {
        $this->signIn();

        $moyu = create('App\Moyu');

        $this->assertDatabaseHas('activities', [
          'type' => 'created_moyu',
          'user_id' => auth()->id(),
          'subject_id' => $moyu->id,
          'subject_type' => 'App\Moyu'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $moyu->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Reply');
        
        $this->assertEquals(2, Activity::count());
    }
}
