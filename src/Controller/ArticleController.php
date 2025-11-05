<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{

    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

//    #[Route('/article', name: 'app_article')]
    public function getArticles(): Response
    {
        $articles = $this->em->getRepository(Article::class)->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    public function addArticle(Request $request): Response {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCommentCount(0);
            $article->setLikeCount(0);
            $article->setViewCount(0);
            $article->setSlug(strtolower(str_replace(' ', '-', $article->getTitle())));
            $article->setCreateAt(new \DateTime());
            $article->setUpdatedAt(new \DateTime());
            $this->em->persist($article);
            $this->em->flush();
            return $this->redirectToRoute('getArticles');
        }
        return $this->render('article/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function updateArticle(Request $request, int $id): Response {
        $article = $this->em->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setSlug(strtolower(str_replace(' ', '-', $article->getTitle())));
            $article->setUpdatedAt(new \DateTime());
            $this->em->persist($article);
            $this->em->flush();
            return $this->redirectToRoute('getArticles');
        }
        return $this->render('article/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function deleteArticle(int $id): Response {
        $article = $this->em->getRepository(Article::class)->find($id);
        $this->em->remove($article);
        $this->em->flush();
        return $this->redirectToRoute('getArticles');
    }
}
