<?php

namespace App\Http\Controllers\Arduino;

use App\Http\Controllers\Controller;
use App\Interfaces\ArduinoConnectableInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DHTController extends Controller
{
    const SLUG = '/dht';

    public function getDHT(ArduinoConnectableInterface $connection): array
    {
        $client = new Client(['timeout' => 2.0]);
        try {
            $response = $client->get($this->buildURL($connection));
        } catch (\Exception $e) {
            Log::error('DGTController: get DHT failed');
            Log::error($e->getMessage());
            return $this->responseToArray('');
        }

        return $this->responseToArray($response->getBody());
    }

    private function buildURL(ArduinoConnectableInterface $connection): string
    {
        $domain = $connection->getArduinoIP();
        if (!$domain) {
            return '';
        }

        return 'http://' . $domain . self::SLUG;
    }

    private function responseToArray(string $jsonResponse): array
    {
        $result = [
            'humidity' => '',
            'temperature' => ''
        ];

        $decodedJson = json_decode($jsonResponse, true);

        if (isset($decodedJson['humidity'])) {
            $result['humidity'] = $decodedJson['humidity'];
        }

        if (isset($decodedJson['temperature'])) {
            $result['temperature'] = $decodedJson['temperature'];
        }

        return $result;
    }
}
