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
class ApiController extends AbstractController
{

    private $commentsRepository;

    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    /**
     * @Route("/comments", name="comments_index", methods={"GET"})
     */
    public function index(): Response
    {
        //Récupérer tous les commentaires depuis la BD
        $data = $this->commentsRepository->findAll();
        return $this->json($data, 200, [], ['groups' => 'comment:group']);
    }

    /**
     * @Route("/page/{page<\d+>}", name="comments_page", methods={"GET"})
     * 
     */
    public function page(Request $request): Response
    {
        //Récupérer les commenntaires selon article/page depuis la BD {https://127.0.0.1:8000/api/page/1}
        $data = $this->commentsRepository->findByArticleId($request->attributes->get('page'));
        return $this->json($data, 200, [], ['groups' => 'comment:group']);
    }
}
