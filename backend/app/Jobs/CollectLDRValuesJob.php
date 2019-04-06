<?php

namespace App\Jobs;

use App\Curtain;
use App\Http\Controllers\Arduino\LDRController;
use App\Interfaces\ArduinoConnectableInterface;
use App\LDR;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CollectLDRValuesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $controller;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
        $this->controller = new LDRController();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $curtains = Curtain::all();

        foreach ($curtains as $curtain) {
            $this->evaluate($curtain, $curtain->id);
        }
    }

    private function evaluate(ArduinoConnectableInterface $connection, int $id): void
    {
        $count = 0;
        $value = 0;

        for ($i = 0; $i < 3; $i++) {
            $values = $this->controller->getLightIntensive($connection);
            if (is_numeric($values['sun_intensive'])) {
                $count++;
                $value += $values['sun_intensive'];
            }
        }

        if (!$count) {
            return;
        }

        $ldr = new LDR();
        $ldr->curtain_id = $id;
        $ldr->value = $value / $count;
        $ldr->save();
    }
}
