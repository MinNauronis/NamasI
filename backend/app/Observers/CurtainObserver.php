<?php

namespace App\Observers;

use App\Curtain;
use App\Http\Controllers\Arduino\CurtainController;
use App\Leds;

class CurtainObserver
{
    private $arduinoController;

    public function __construct(CurtainController $controller)
    {
        $this->arduinoController = $controller;
    }

    public function created(Curtain $curtain): void
    {
        $leds = new Leds();
        $leds->curtain_id = $curtain->id;
        $leds->owner_id = $curtain->owner->id;
        $leds->save();
    }

    public function updated(Curtain $curtain): void
    {
        if ($curtain->is_activated) {
            $this->arduinoController->updateCurtain($curtain, ['close_at' => $curtain->close_at]);
        }
    }
}
