<?php

namespace Tests\Feature;

use App\Curtain;
use App\Jobs\CollectLDRValuesJob;
use App\LDR;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LDRJobTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function read_values_and_create_ldr_object()
    {
        $curtain = factory(Curtain::class)->create([
            'micro_controller_id' => env('TEST_ARDUINO_IP')
        ]);
        $expectedCount = LDR::all()->count() + Curtain::all()->count();

        $job = new CollectLDRValuesJob();
        $job->handle();

        $this->assertCount($expectedCount, LDR::all());
    }

    /** @test */
    public function try_to_read_values_when_ip_is_incorrect()
    {
        $curtain = factory(Curtain::class)->create([
            'micro_controller_id' => '111.111.111.111'
        ]);
        $expectedCount = LDR::all()->count();

        $job = new CollectLDRValuesJob();
        $job->handle();

        $this->assertCount($expectedCount, LDR                                                                             ::all());
    }
}
