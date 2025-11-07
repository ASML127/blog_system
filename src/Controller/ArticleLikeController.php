<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ArticleLikeController extends AbstractController
{

    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

//    #[Route('/article/like', name: 'app_article_like')]
    public function addLike(int $id, string $title): Response
    {
        $article = new Article();
        $article->setAuthor($this->getUser());
        $article->setLikeCount(1);
        $this->em->persist($article);
        $this->em->flush();
        return $this->render('getArticle', [
            'id' => $id,
        ]);
    }
}
