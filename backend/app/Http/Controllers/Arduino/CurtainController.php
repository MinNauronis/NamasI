<?php

namespace App\Http\Controllers\Arduino;

use App\Http\Controllers\Controller;
use App\Interfaces\ArduinoConnectableInterface as Connectable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CurtainController extends Controller
{
    const SLUG = '/curtain';

    public function updateCurtain(Connectable $connectable, array $attributes): bool
    {
        $client = new Client(['timeout' => 2.0]);

        try {
            $response = $client->post( $this->buildURL($connectable), ['form_params' => $attributes]);
        } catch (\Exception $e) {
            Log::error('CurtainContoller: update curtain failed');
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
