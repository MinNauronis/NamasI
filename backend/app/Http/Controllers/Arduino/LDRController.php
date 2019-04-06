<?php

namespace App\Http\Controllers\Arduino;


use App\Http\Controllers\Controller;
use App\Interfaces\ArduinoConnectableInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LDRController extends Controller
{
    const SLUG = '/sun_intensive';

    /**
     * Return associative array of read value
     * @param ArduinoConnectableInterface $connection
     * @return array
     */
    public function getLightIntensive(ArduinoConnectableInterface $connection): array
    {
        $client = new Client(['timeout' => 2.0]);
        try {
            $response = $client->get($this->buildURL($connection));
        } catch (\Exception $e) {
            Log::error('LDRController: get light intensive failed');
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
            'sun_intensive' => '',
        ];

        $decodedJson = json_decode($jsonResponse, true);

        if (isset($decodedJson['sun_intensive'])) {
            $result['sun_intensive'] = $decodedJson['sun_intensive'];
        }

        return $result;
    }
}
