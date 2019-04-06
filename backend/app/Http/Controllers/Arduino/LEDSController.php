<?php

namespace App\Http\Controllers\Arduino;

use App\Http\Controllers\Controller;
use App\Interfaces\ArduinoConnectableInterface as Connectable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LEDSController extends Controller
{
    const SLUG = '/leds';

    public function updateLEDS(Connectable $connectable, array $attributes): bool
    {
        $client = new Client(['timeout' => 2.0]);

        try {
            $response = $client->post($this->buildURL($connectable), ['form_params' => $attributes]);
        } catch (\Exception $e) {
            Log::error('LEDSController: update LEDS failed');
            Log::error($e->getMessage());
            return false;
        }

        return true;
    }

    private function buildURL(Connectable $connection): string
    {
        $domain = $connection->getArduinoIP();
        if (!$domain) {
            return '';
        }

        return 'http://' . $domain . self::SLUG;
    }
}
