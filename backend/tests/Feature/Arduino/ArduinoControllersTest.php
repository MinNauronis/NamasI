<?php

namespace Tests\Feature\Arduino;


use App\Curtain;
use App\Http\Controllers\Arduino\CurtainController;
use App\Http\Controllers\Arduino\DHTController;
use App\Http\Controllers\Arduino\LDRController;
use App\Http\Controllers\Arduino\LEDSController;
use App\Leds;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArduinoControllersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function get_DHT()
    {
        $arduinoConnectable = factory(Curtain::class)->create([
            'micro_controller_id' => env('TEST_ARDUINO_IP', '111.111.111.111')
        ]);
        $controller = new DHTController();

        $response = $controller->getDHT($arduinoConnectable);

        $this->assertCount(2, $response);
        $this->assertArrayHasKey('humidity', $response);
        $this->assertArrayHasKey('temperature', $response);
    }

    /** @test */
    public function get_LDR()
    {
        $arduinoConnectable = factory(Curtain::class)->create([
            'micro_controller_id' => env('TEST_ARDUINO_IP', '111.111.111.111')
        ]);
        $controller = new LDRController();

        $response = $controller->getLightIntensive($arduinoConnectable);

        $this->assertCount(1, $response);
        $this->assertArrayHasKey('sun_intensive', $response);
    }

    /** @test */
    public function move_curtain()
    {
        $arduinoConnectable = factory(Curtain::class)->create([
            'micro_controller_id' => env('TEST_ARDUINO_IP', '111.111.111.111'),
            'is_activated' => true,
        ]);
        $controller = new CurtainController();
        $atributes = [
            'close_at' => 95,
        ];

        $response = $controller->updateCurtain($arduinoConnectable, $atributes);

        $this->assertTrue($response);
    }

    /** @test */
    public function update_leds()
    {
        $curtain = factory(Curtain::class)->create([
            'micro_controller_id' => env('TEST_ARDUINO_IP', '111.111.111.111'),
        ]);

        $controller = new LEDSController();
        $atributes = [
            'brightness' => 60,
            'mode' => LEDS::MODES[2],
            'color' => '22,33,44',
            'change_rate' => 50,
        ];

        $response = $controller->updateLEDS($curtain, $atributes);

        $this->assertTrue($response);
    }
}
