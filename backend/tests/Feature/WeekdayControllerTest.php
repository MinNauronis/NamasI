<?php

namespace Tests\Feature;

use App\Schedule;
use App\Weekday;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeekdayControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function get_weekdays()
    {
        $this->withoutExceptionHandling();

        $schedule = factory(Schedule::class)->create();
        $user = $schedule->owner;

        $this->actingAs($user)
            ->json('GET', 'api/schedules/' . $schedule->id . '/days/')
            ->assertJsonCount(7);
    }

    /** @test */
    public function get_day_of_schedule()
    {
        $this->withoutExceptionHandling();

        $schedule = factory(Schedule::class)->create();
        $user = $schedule->owner;
        $expectedDay = $schedule->weekdays->first();

        $this->actingAs($user)
            ->json('GET', 'api/schedules/' . $schedule->id . '/days/' . $expectedDay->id)
            ->assertJsonFragment([
                'id' => $expectedDay->id,
                'mode' => $expectedDay->mode,
                'close_time' => $expectedDay->close_time,
                'weekday' => $expectedDay->weekday,
            ]);
    }

    /** @test */
    public function update_weekday()
    {
        $this->withoutExceptionHandling();

        $weekday = factory(Weekday::class)->create();
        $user = $weekday->owner;
        $attribubes = [
            'mode' => 'auto',
            'close_time' => '21:59',
            'open_time' => '06:22'
        ];

        $this->actingAs($user)
            ->json('PATCH', 'api/schedules/' . $weekday->schedule->id . '/days/' . $weekday->id, $attribubes)
            ->assertJsonFragment($attribubes);
    }

//    /** @test */
//    public function swap_field_of_weekday_on_days()
//    {
//        //rearrange days order
//    }
}
