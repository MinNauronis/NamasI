<?php

namespace Tests\Feature;

use App\Curtain;
use App\DHT;
use App\Jobs\CollectDHTValuesJob;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DHTJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function read_values_and_create_dht_object()
    {
        $curtain = factory(Curtain::class)->create([
           'micro_controller_id' => env('TEST_ARDUINO_IP')
        ]);
        $expectedCount = DHT::all()->count() + Curtain::all()->count();

        $job = new CollectDHTValuesJob();
        $job->handle();

        $this->assertCount($expectedCount, DHT::all());
    }

    /** @test */
    public function try_to_read_values_when_ip_is_incorrect()
    {
        $curtain = factory(Curtain::class)->create([
            'micro_controller_id' => '111.111.111.111'
        ]);
        $expectedCount = DHT::all()->count();

        $job = new CollectDHTValuesJob();
        $job->handle();

        $this->assertCount($expectedCount, DHT::all());
    }
}
