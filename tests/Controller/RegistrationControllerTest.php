<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    /**
     * @dataProvider dataProviderForTest
     */
    public function testRegistrationSuccessfull($email, $password): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/register');
        $token = $crawler->filter('[name="registration_form[_token]"]')->attr("value");
        $form = $crawler->selectButton('Register')->form([
            "registration_form[email]" => $email,
            "registration_form[plainPassword]" => $password,
            "registration_form[_token]" => $token
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testRegistrationUnsuccessfull(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/register');
        $token = $crawler->filter('[name="registration_form[_token]"]')->attr("value");
        // dd($client->getResponse());
        $form = $crawler->selectButton('Register')->form([
            "registration_form[email]" => "tester@gmail.fr",
            "registration_form[plainPassword]" => "motdepasse",
            "registration_form[_token]" => $token
        ]);
        $response = $client->getResponse();
        $client->submit($form);
    }

    public function dataProviderForTest()
    {
        return [
            ['test1@gmail.com', 'motdepasse1'],
            ['test2@gmail.com', 'motdepasse2'],
            ['test3@gmail.com', 'motdepasse3']
        ];
    }
}
