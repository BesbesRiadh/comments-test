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

class IndexController extends AbstractController {

    /**
     * @Route("/", name="app_index")
     */
    public function index(CommentairesService $commentairesService): Response {
        $comments = $commentairesService->findAll();

        return $this->render('index/index.html.twig', [
                    'comments' => $comments,
        ]);
    }

    /**
     * @Route("/page1", name="page1")
     */
    public function page1Action(CommentairesService $commentairesService, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $comments = $commentairesService->findCommentPage1();
        $article = $em->getRepository(Article::class)->find(1);
        $comment = new Comments;
        $commentForm = $this->createForm(CommentsType::class, $comment);

        if ($request->isXmlHttpRequest()) {
            $rating = $request->request->get('rating');
            $id = $request->request->get('id');

            $comment = $em->getRepository(Comments::class)->find($id);
            if ($comment != null) {
                $comment->setRating($rating);
                $em->persist($comment);
                $em->flush();
            }

            $htmlToRender = $this->renderView('index/page1.html.twig', array(
                'texte' => $article->getText(),
                'comments' => $comments,
                'commentForm' => $commentForm->createView(),
            ));

            return new Response($htmlToRender);
        }

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

            return $this->redirectToRoute('page1');
        }

        return $this->render('index/page1.html.twig', [
                    'texte' => $article->getText(),
                    'comments' => $comments,
                    'commentForm' => $commentForm->createView(),
        ]);
    }

    /**
     * @Route("/page2", name="page2")
     */
    public function page2Action(CommentairesService $commentairesService): Response {
        $commentaires = $commentairesService->findAll();
        var_dump($commentaires);
        exit;
        return $this->render('index/page2.html.twig', [
                    'controller_name' => 'IndexController',
        ]);
    }

}
