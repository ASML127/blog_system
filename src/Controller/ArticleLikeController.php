<?php

namespace App\Controller;

use App\Entity\ArticleLike;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleLikeController extends AbstractController
{
//    #[Route('/article/like', name: 'app_article_like')]
    public function addLike(): Response
    {
        $like = new ArticleLike();
        $like->setArticule($like->getArticule() + 1);

        return $this->json($like);
    }
}
