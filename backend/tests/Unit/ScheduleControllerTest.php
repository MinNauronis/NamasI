<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleControllerTest extends TestCase
{
    private $url = '/api/curtains/15/schedules/';
    private $correctScheduleId = 23;
    private $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ];

    public function testPost_201()
    {
        $data = [
            'title' => 'ScheduleTesting',
            'image' => null,
        ];

        $response = $this->createSchedule($data, false);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(201);
    }

    /**
     * @param array $data
     * @param bool $contentOnly
     * @return \Illuminate\Foundation\Testing\TestResponse|string
     */
    private function createSchedule(
        array $data = ['title' => 'ScheduleTest'],
        bool $contentOnly = true
    )
    {
        return $contentOnly ?
            $this->json('POST', $this->url, $data, $this->headers)
                ->baseResponse->getContent() :
            $this->json('POST', $this->url, $data, $this->headers);
    }

    public function testPost_422()
    {
        $data = [
            'title' => '',
        ];

        $response = $this->createSchedule($data, false);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(422);
    }

    public function testGetAllAction()
    {
        $response = $this->json('GET', $this->url, [], $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testGet_200()
    {
        $schedule = $this->createSchedule();
        $scheduleId = $this->getId($schedule);
        $response = $this->json('GET', $this->url . $scheduleId, [], $this->headers);
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
    public function testGet_400()
    {
        $schedule = $this->createSchedule();
        $scheduleId = $this->getId($schedule);
        $response = $this->json('GET', '/api/curtains/16/schedules/' . $scheduleId, [], $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(404);
    }

    public function testPut_200()
    {
        $data = [
            'title' => 'ScheduleTestUpdate',
            'image' => null
        ];

        $response = $this->json('PUT', $this->url . $this->correctScheduleId, $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testPut_422()
    {

        $data = [
            'title' => '',
            'image' => null
        ];

        $response = $this->json('PUT', $this->url . $this->correctScheduleId, $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(422);
    }

    public function testPatch_200()
    {
        $data = [
            'title' => 'SchedulePatch',
            'image' => null
        ];


        $response = $this->json('PATCH', $this->url.$this->correctScheduleId, $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testPatch_422()
    {
        $data = [
            'title' => '',
            'image' => null
        ];


        $response = $this->json('PATCH', $this->url.$this->correctScheduleId, $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(422);
    }

    public function testDelete_200()
    {
        $data = [
            'title' => 'Delete_200',
        ];

        $newSchedule = $this->createSchedule($data);
        $id = $this->getId($newSchedule);
        $response = $this->json('DELETE', $this->url . $id, $data, $this->headers);

        $response->assertStatus(200);
    }
}
