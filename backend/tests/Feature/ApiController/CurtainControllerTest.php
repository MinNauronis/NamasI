<?php

namespace Tests\Feature;

use App\Curtain;
use App\Http\Resources\CurtainResource;
use App\Leds;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurtainControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function store_new_curtain()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $attributes = [
            'title' => 'My testing curtain',
            'micro_controller_id' => '255.255.255.255',
            'is_activated' => true,
        ];

        $this->actingAs($user)
            ->json('POST', 'api/curtains/', $attributes);

        $this->assertDatabaseHas('curtains', ['title' => $attributes['title']]);
    }

    /** @test */
    public function get_all_curtains_of_user()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        factory(Curtain::class, 3)->create(['owner_id' => $user->id]);

        $this->actingAs($user)
            ->json('GET', 'api/curtains')
            ->assertJsonCount(3);
    }

    /** @test */
    public function get_curtain_of_user()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $curtains = factory(Curtain::class, 3)->create(['owner_id' => $user->id]);
        $curtain = Curtain::find($curtains[0]->id);

        $this->actingAs($user)
            ->json('GET', 'api/curtains/' . $curtain->id)
            ->assertJsonFragment([
                'micro_controller_id' => $curtain->micro_controller_id,
                'title' => $curtain->title,
                'mode' => $curtain->mode
            ]);
    }

    /** @test */
    public function update_curtain()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $curtain = factory(Curtain::class)->create(['owner_id' => $user->id]);
        $expectedAttributes = [
            'title' => 'ACME',
            'micro_controller_id' => '125.123.123.123',
            'is_close' => true,
            'is_activated' => false,
            'mode' => 'manual',
            'select_schedule_id' => null,
        ];

        $this->actingAs($user)
            ->json('PATCH', 'api/curtains/' . $curtain->id, $expectedAttributes)
            ->assertJson($expectedAttributes);
    }

    /** @test */
    public function delete_curtain()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $curtain = factory(Curtain::class)->create(['owner_id' => $user->id]);

        $this->actingAs($user)
            ->json('DELETE', 'api/curtains/' . $curtain->id);

        $this->assertDatabaseMissing('curtains', [
            'title' => $curtain['title'],
            'micro_controller_id' => $curtain['micro_controller_id'],
            'is_close' => $curtain['is_close'],
        ]);
    }

    /** @test */
    public function create_leds_on_curtain_creation()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $attributes = [
            'title' => 'My testing curtain',
            'micro_controller_id' => '255.255.255.255',
            'is_activated' => true,
        ];

        $this->actingAs($user)
            ->json('POST', 'api/curtains/', $attributes);

        $this->assertDatabaseHas('leds', ['curtain_id' => Curtain::all()->last()->id]);
    }

    /** @test */
    public function delete_leds_on_curtain_deletion()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $attributes = [
            'title' => 'My testing curtain',
            'micro_controller_id' => '255.255.255.255',
            'is_activated' => true,
        ];
        $this->actingAs($user)
            ->json('POST', 'api/curtains/', $attributes);
        $this->actingAs($user)
            ->json('POST', 'api/curtains/', $attributes);
        $ledsCount = Leds::all()->count();

        $this->actingAs($user)
            ->json('DELETE', 'api/curtains/' . Curtain::all()->last()->id);

        self::assertCount($ledsCount-1, Leds::all());
    }
}
