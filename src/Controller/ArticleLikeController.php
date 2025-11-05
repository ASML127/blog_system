<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleLikeController extends AbstractController
{
    #[Route('/article/like', name: 'app_article_like')]
    public function index(): Response
    {
        return $this->render('article_like/index.html.twig', [
            'controller_name' => 'ArticleLikeController',
        ]);
    }
}
