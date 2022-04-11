<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentsRepository;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController {

    private $commentsRepository;

    public function __construct(CommentsRepository $commentsRepository) {
        $this->commentsRepository = $commentsRepository;
    }

    /**
     * @Route("/comments", name="comments_index", methods={"GET"})
     */
    public function index(): Response {
        $data = $this->commentsRepository->findAll();

        return $this->json($data, 200, [], ['groups' => 'comment:group']);
    }

    /**
     * @Route("/page1", name="comments_page1", methods={"GET"})
     * @Route("/page2", name="comments_page2", methods={"GET"})
     */
    public function page(Request $request): Response {
        $routeName = $request->attributes->get('_route');
        switch ($routeName) {
            case "api_comments_page1":
                $data = $this->commentsRepository->findByArticleId(1);
                break;
            case "api_comments_page2":
                $data = $this->commentsRepository->findByArticleId(2);
                break;
        }

        return $this->json($data, 200, [], ['groups' => 'comment:group']);
    }

}
