<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiControllerTest extends WebTestCase {

    public function testIndex(): void {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/comments');

        $response = $client->getResponse();
        $this->assertNotEmpty($response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testPage1(): void {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/page1');

        $response = $client->getResponse();
        $this->assertNotEmpty($response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testPage2(): void {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/page2');
        
        $response = $client->getResponse();
        $this->assertNotEmpty($response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

}
