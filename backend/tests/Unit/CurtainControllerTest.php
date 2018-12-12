<?php

namespace Tests\Unit;

use App\Http\Controllers\CurtainController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class CurtainControllerTest extends TestCase
{
    private $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ];

    public function testGetAllAction()
    {
        $response = $this->json('GET', '/api/curtains', [], $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testGet()
    {
        $response = $this->json('GET', '/api/curtains/1', [], $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testPost_201()
    {
        $data = [
            'title' => 'Tamsa',
            'microControllerIp' => '111.111.111.111',
            'isClose' => '1',
            'isTurnOn' => '1',
            'mode' => 'off'
        ];

        $response = $this->json('POST', '/api/curtains', $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(201);
    }

    public function testPost_422()
    {
        $data = [
            'title' => '',
            'microControllerIp' => '111.111.111.111',
            'isClose' => '1',
            'isTurnOn' => '1',
            'mode' => 'off'
        ];

        $response = $this->json('POST', '/api/curtains', $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(422);
    }

    public function testPut_200()
    {
        $data = [
            'title' => 'Update',
            'microControllerIp' => '111.111.111.111',
            'isClose' => '1',
            'isTurnOn' => '1',
            'mode' => 'off'
        ];

        $response = $this->json('PUT', '/api/curtains/15', $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testPut_422()
    {
        $data = [
            'title' => 'Update422',
            'microControllerIp' => '111.111.111',
            'isClose' => '1',
            'isTurnOn' => '1',
            'mode' => 'off'
        ];

        $response = $this->json('PUT', '/api/curtains/15', $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(422);
    }

    public function testPut_selectScheduleId()
    {
        $data = [
            'selectSchedule_id' => '12',
        ];

        $response = $this->json('PUT', '/api/curtains/1', $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testPatch_200()
    {
        $data = [
            'title' => 'Update',
            'microControllerIp' => '111.111.111.111',
            'isClose' => '1',
            'isTurnOn' => '1',
            'mode' => 'off'
        ];

        $response = $this->json('PATCH', '/api/curtains/15', $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(200);
    }

    public function testPatch_422()
    {
        $data = [
            'title' => 'Update422',
            'microControllerIp' => '111.111.111',
            'isClose' => '1',
            'isTurnOn' => '1',
            'mode' => 'off'
        ];

        $response = $this->json('PATCH', '/api/curtains/15', $data, $this->headers);
        //fwrite(STDERR, print_r($response, TRUE));

        $response->assertStatus(422);
    }

    public function testDelete_200()
    {
        $data = [
            'title' => 'Delete_200',
        ];

        $newCurtain = $this->json('POST', '/api/curtains', $data, $this->headers)
            ->baseResponse->getContent();
        $id = $this->getId($newCurtain);
        $response = $this->json('DELETE', '/api/curtains/'.$id, $data, $this->headers);

        $response->assertStatus(200);
    }

    private function getId($jsonData): ?int
    {

        $decodeJson = json_decode($jsonData, true);

        return isset($decodeJson['curtain']['id']) ? $decodeJson['curtain']['id'] : null;
    }
}
