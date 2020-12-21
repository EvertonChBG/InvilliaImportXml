<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class apiGetPeopleTest extends TestCase
{
    /**
     * Import File People
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @test
     */
    public function must_bring_success_in_get_people()
    {
        $oMock = new MockHandler([
            new Response(200,['X-Foo' => 'Bar'],'Hello, World'),
            new Response(202,['Content-Length' => 0]),
            new RequestException('Error Communicating with Server',new Request('GET','test'))
        ]);

        $oHandlerStack = HandlerStack::create($oMock);
        $oClient = new Client(['handler' => $oHandlerStack]);

        $oResponse = $oClient->request('GET','/peoples');

        $this->assertEquals(200, $oResponse->getStatusCode());

        $oMock->reset();
        $oMock->append(new Response(201));

        echo $oClient->request('GET','/people')->getStatusCode();
    }

    /**
     * Import File People
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @test
     */
    public function must_bring_success_in_get_data_people()
    {

        $oClient = new Client();
        $oResponse = $oClient->get('http://localhost:8100/api/peoples');

        $this->assertEquals(200, $oResponse->getStatusCode());

       // dd($oResponse->getBody()->getContents());

        // $userAgent = json_decode($oResponse->getBody())->{"user-agent"};
//        $this->assertRegexp('/Guzzle/', $userAgent);

//        dd(env('APP_URL'). '/api/peoples/999999999');
//
//        $oResponse = $oClient->request('GET',env('APP_URL'). '/api/peoples/999999999');
//
//        $this->assertEquals(404, $oResponse->getStatusCode());
//
//        echo $oClient->request('GET','/people')->getStatusCode();
    }

}
