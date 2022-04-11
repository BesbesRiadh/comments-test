<?php

namespace App\Service;

use App\Repository\CommentsRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommentairesService {

    private $client;

    public function __construct(HttpClientInterface $client, CommentsRepository $commentsRepository) {
        $this->client = $client;
        $this->commentsRepository = $commentsRepository;
    }

    public function findAll(): array {
        $response = $this->client->request(
                "GET",
                'https://127.0.0.1:8000/api/comments'
        );
        return $response->toArray();
    }

    public function findCommentPage1() {
        $data = $this->commentsRepository->findByArticleId(1);
        return $data;
    }

    public function findCommentPage($page) {
        $url = "https://127.0.0.1:8000/api/" . $page;
        $response = $this->client->request(
                "GET", $url
        );
        return $response->toArray();
    }

}
