<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CommentairesService;
use App\Entity\Comments;
use App\Entity\Article;
use App\Form\CommentsType;
use DateTimeImmutable;

class IndexController extends AbstractController
{

    /**
     * @Route("/", name="app_index")
     */
    public function index(CommentairesService $commentairesService): Response
    {
        //Récupérer et afficher tous les commentaires
        $comments = $commentairesService->findAll();
        return $this->render('index/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/page/{page<\d+>}", name="page")
     */
    public function pageAction(CommentairesService $commentairesService, Request $request)
    {
        $page = $request->attributes->get('page');
        $em = $this->getDoctrine()->getManager();   

        //Récupérer les commentaires de $page 
        $comments = $commentairesService->findCommentPage($page);
        //Récupérer l'article associé aux commentaires
        $article = $em->getRepository(Article::class)->find($page);

        $comment = new Comments;
        $commentForm = $this->createForm(CommentsType::class, $comment);

        //Traitement de la requête AJAX pour le système de rating si elle est déclenchée
        if ($request->isXmlHttpRequest()) {
            $rating = $request->request->get('rating');
            $id = $request->request->get('id');

            $comment = $em->getRepository(Comments::class)->find($id);
            if ($comment != null) {
                $comment->setRating($rating);
                $em->persist($comment);
                $em->flush();
            }

            $htmlToRender = $this->renderView('index/page.html.twig', array(
                'texte' => $article->getText(),
                'comments' => $comments,
                'commentForm' => $commentForm->createView(),
            ));

            return new Response($htmlToRender);
        }

        //Traitement des infos du form des commentaires
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $parentid = $commentForm->get("parentid")->getData();
            if ($parentid != null) {
                $parent = $em->getRepository(Comments::class)->find($parentid);
            }

            $comment->setParent($parent ?? null);
            $comment->setArticle($article);
            $comment->setCreatedAt(new DateTimeImmutable());
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute($request->headers->get('referer'));
        }

        return $this->render('index/page.html.twig', [
            'texte' => $article->getText(),
            'comments' => $comments,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
