<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

   public function testPage1(): void
   {
       $client = static::createClient();
       $crawler = $client->request('GET', '/page1');

       $response = $client->getResponse();
       $this->assertNotEmpty($response);
   }
}
