<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeekdayControllerTest extends TestCase
{
    private $url = '/api/schedules/26/days/';
    private $correntDayId = 180;
    private $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ];

    public function testGetAllAction()
    {
        $response = $this->json('GET', $this->url, [], $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testGet_200()
    {
        $response = $this->json('GET', $this->url . $this->correntDayId, [], $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    /**
     * @param $jsonData
     * @return string
     */
    private function getId($jsonData)
    {

        $decodeJson = json_decode($jsonData, true);

        return isset($decodeJson['schedule']['id']) ? $decodeJson['schedule']['id'] : null;
    }

    /**
     * Incorrect curtain id
     */
    public function testGet_404()
    {

        $badDay = $this->correntDayId - 10;
        $response = $this->json('GET', '/api/schedules/30/days/' . $this->correntDayId, [], $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(404);
    }

    public function testPut_200()
    {
        $weekday = 5;
        $data = [
            'title' => 'DayPatch',
            'weekday' => $weekday,
            'mode' => 'skip',
            'openTime' => '08:00:00',
            'closeTime' => '20:00:00'
        ];


        $response = $this->json('PUT', $this->url . $this->correntDayId, $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testPut_422()
    {
        $weekday = 5;
        $data = [
            'title' => 'DayPatch',
            'weekday' => $weekday,
            'mode' => 'mode not exist',
            'openTime' => '08:00:00',
            'closeTime' => '20:00:00'
        ];

        $response = $this->json('PUT', $this->url . $this->correntDayId, $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(422);
    }
}
