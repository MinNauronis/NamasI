<?php

namespace App\Jobs;

use App\Curtain;
use App\DHT;
use App\Http\Controllers\Arduino\DHTController;
use App\Interfaces\ArduinoConnectableInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CollectDHTValuesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $controller;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
        $this->controller = new DHTController();
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
        $humidity = 0;
        $temperature = 0;

        for ($i = 0; $i < 3; $i++) {
            $values = $this->controller->getDHT($connection);
            if (is_numeric($values['humidity'])) {
                $count++;
                $humidity += $values['humidity'];
                $temperature += $values['temperature'];
            }
        }

        if (!$count) {
            return;
        }

        $dht = new DHT();
        $dht->curtain_id = $id;
        $dht->humidity = $humidity / $count;
        $dht->temperature = $temperature / $count;
        $dht->save();
    }
}
