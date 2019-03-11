<?php

namespace Tests\Feature;

use App\Curtain;
use App\Schedule;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function get_all_schedules_of_curtain()
    {
        $this->withoutExceptionHandling();


        $curtain = factory(Curtain::class)->create();
        $user = $curtain->owner;
        $schedules = factory(Schedule::class, 4)->create([
            'curtain_id' => $curtain->id,
            'owner_id' => $user->id
        ]);


        $this->actingAs($user)
            ->json('GET', 'api/curtains/' . $curtain->id . '/schedules/')
            ->assertJsonCount(4);

    }

    /** @test */
    public function get_schedule_of_curtain()
    {
        $this->withoutExceptionHandling();

        $schedule = factory(Schedule::class)->create();
        $user = $schedule->owner;

        $this->actingAs($user)
            ->json('GET', 'api/curtains/' . $schedule->curtain->id . '/schedules/' . $schedule->id)
            ->assertJsonFragment([
                'title' => $schedule->title,
            ]);
    }

    /** @test */
    public function store_new_schedule()
    {
        $this->withoutExceptionHandling();

        $curtain = factory(Curtain::class)->create();
        $user = $curtain->owner;
        $attributes = [
            'title' => 'This is my best schedule',
            'image' => UploadedFile::fake()->image('fake_image.webp'),
        ];

        $this->actingAs($user)
            ->json('POST', 'api/curtains/' . $curtain->id . '/schedules/', $attributes);

        $this->assertDatabaseHas('schedules', [
            'curtain_id' => $curtain->id,
            'title' => 'This is my best schedule',
        ]);
    }

    /** @test */
    public function update_schedule()
    {
        $this->withoutExceptionHandling();

        $schedule = factory(Schedule::class)->create();
        $attributes = [
            'title' => 'Best title ever',
        ];

        $this->json('PATCH', 'api/curtains/' . $schedule->curtain->id . '/schedules/' . $schedule->id,
            $attributes);

        $this->assertDatabaseHas('schedules', ['title' => $attributes['title']]);

    }

    /** @test */
    public function delete_schedule()
    {
        $this->withoutExceptionHandling();

        $schedules = factory(Schedule::class, 3)->create();
        $user = $schedules[0]->owner;

        $this->actingAs($user)
            ->json('DELETE', 'api/curtains/' . $schedules[0]->curtain->id . '/schedules/' . $schedules[0]->id);

        $this->assertDatabaseMissing('schedules', [
            'id' => $schedules[0]->id,
        ]);
    }

    /** @test */
    public function seven_days_are_created_when_schedule_is_created()
    {
        $this->withoutExceptionHandling();

        $curtain = factory(Curtain::class)->create();
        $user = $curtain->owner;
        $attributes = [
            'title' => 'This is my best schedule',
            'image' => UploadedFile::fake()->image('fake_image.webp'),
        ];

        $response = $this->actingAs($user)
            ->json('POST', 'api/curtains/' . $curtain->id . '/schedules/', $attributes);

        $decodedJSON = json_decode($response->getContent(), true);
        $this->assertDatabaseHas('weekdays', [
           'schedule_id' => $decodedJSON['id'],
        ]);
    }

    /** @test */
    public function schedule_days_deletes_together_with_schedule()
    {
        $schedule = factory(Schedule::class)->create();
        $user = $schedule->owner;

        $this->assertDatabaseHas('weekdays', ['schedule_id' => $schedule->id]);

        $this->actingAs($user)
            ->json('DELETE', 'api/curtains/'.$schedule->curtain->id.'/schedules/'.$schedule->id);


        $this->assertDatabaseMissing('weekdays', ['schedule_id' => $schedule->id]);
    }


//    /** @test */
//    public function image_is_saved_correctly()
//    {
//        //todo implement
//    }

//last image must be removed, new inserted
//    /** @test */
//    public function image_is_updated_correctly()
//    {
//        //todo implement
//    }
}
