<?php

namespace App\Service;

use App\Repository\CommentsRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// Ce service permet de récupérer les commentaires depuis l'API
class CommentairesService
{

    private $client;
    private $appUrl;

    public function __construct(HttpClientInterface $client, CommentsRepository $commentsRepository, $apiUrl)
    {
        $this->client = $client;
        $this->commentsRepository = $commentsRepository;
        $this->apiUrl = $apiUrl;
    }

    public function findAll(): array
    {
        //Récupérer les commentaires depuis l'api
        $url =  $this->apiUrl .'/comments';
        $response = $this->client->request(
            "GET",
            $url
        );
        return $response->toArray();
    }

    public function findCommentPage($page)
    {
        //Récupérer les commentaires depuis API selon page
        $url = $this->apiUrl . '/page' . $page;
        $response = $this->client->request(
            "GET",
            $url
        );
        return $response->toArray();
    }
}
