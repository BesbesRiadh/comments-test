<?php
namespace App\Service;

use App\Repository\CommentsRepository;

class CommentairesService
{
    private $commentsRepository;

    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }
    public function findAll()
    {
        $data = $this->commentsRepository->findAll();
        return $data;
    }

    public function findCommentPage1()
    {
        $data = $this->commentsRepository->findByArticleId(1);
        return $data;
    }

    public function findCommentPage2()
    {
        $data = $this->commentsRepository->findOneByArticle(2);
        return $data;
    }
}