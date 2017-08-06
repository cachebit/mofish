<?php

namespace Tests\Unit;

use Carbon\Carbon;
use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_records_activity_when_a_moyu_is_created()
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
    function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        create('App\Moyu', ['user_id' => auth()->id()], 2);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subweek()]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
          Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
          Carbon::now()->subweek()->format('Y-m-d')
        ));
    }
}
