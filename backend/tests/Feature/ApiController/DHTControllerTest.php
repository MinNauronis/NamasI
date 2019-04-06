<?php

namespace Tests\Feature;

use App\Curtain;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DHTControllerTest extends TestCase
{
    /** @test */
    public function get_dht_values()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $curtain = factory(Curtain::class)->create([
            'owner_id' => $user->id,
            'micro_controller_id' => env('TEST_ARDUINO_IP')
        ]);

        $this->actingAs($user)
            ->json('GET', 'api/dht/'.$curtain->id)
            ->assertStatus(200)
            ->assertJsonFragment(['humidity']);
    }
}
