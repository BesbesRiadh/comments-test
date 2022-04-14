<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    // public function testRegistrationSuccessfull(): void
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request('POST', '/register');
    //     $token = $crawler->filter('[name="registration_form[_token]"]')->attr("value");
    //     // dd($token);
    //     $form = $crawler->selectButton('Register')->form([
    //         "registration_form[email]" => "tester@gmail.fr",
    //         "registration_form[plainPassword]" => "motdepasse",
    //         "registration_form[_token]" => $token
    //     ]);

    //     $client->submit($form);
    //     $this->assertResponseRedirects('/');
    //     $client->followRedirect();
    //     $this->assertResponseIsSuccessful();
    // }

    public function testRegistrationUnsuccessfull(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/register');
        $token = $crawler->filter('[name="registration_form[_token]"]')->attr("value");
        // dd($token);
        $form = $crawler->selectButton('Register')->form([
            "registration_form[email]" => "tester@gmail.fr",
            "registration_form[plainPassword]" => "motdepasse",
            "registration_form[_token]" => $token
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/register');
        $client->followRedirect();
    }
}
