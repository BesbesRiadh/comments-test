<?php

namespace App\Service;

use App\Repository\CommentsRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
        $url =  $this->apiUrl .'/comments';
        $response = $this->client->request(
            "GET",
            $url
        );
        return $response->toArray();
    }

    public function findCommentPage($page)
    {
        $url = $this->apiUrl . $page;
        $response = $this->client->request(
            "GET",
            $url
        );
        return $response->toArray();
    }
}
