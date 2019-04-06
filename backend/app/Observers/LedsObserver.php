<?php

namespace App\Observers;

use App\Http\Controllers\Arduino\LEDSController;
use App\Http\Resources\LedsResource;
use App\Leds;

class LedsObserver
{
    private $arduinoController;

    public function __construct(LEDSController $controller)
    {
        $this->arduinoController = $controller;
    }

    public function update(Leds $leds): void
    {
        $attributes = $this->collectAttributes($leds);
        $this->arduinoController->updateLEDS($leds->curtain, $attributes);
    }

    private function collectAttributes(Leds $leds): array
    {
        $decodedColor = json_decode($leds->color, true);

        return [
            'brightness' => $leds->brightness,
            'mode' => $leds->mode,
            'change_rate' => $leds->change_rate,
            'color' => $decodedColor['red'] . ',' . $decodedColor['green'] . ',' . $decodedColor['blue'],
        ];
    }
}
