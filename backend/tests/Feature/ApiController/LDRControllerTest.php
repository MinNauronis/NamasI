<?php

namespace Tests\Feature;

use App\Curtain;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LDRControllerTest extends TestCase
{
    /** @test */
    public function get_ldr()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $curtain = factory(Curtain::class)->create([
            'owner_id' => $user->id,
            'micro_controller_id' => env('TEST_ARDUINO_IP')
        ]);

        $this->actingAs($user)
            ->json('GET', 'api/light/'.$curtain->id)
            ->assertStatus(200)
            ->assertJsonFragment(['light']);
    }
}
