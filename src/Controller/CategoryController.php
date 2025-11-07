<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function getCategories(): Response
    {
        $categories = $this->em->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    public function addCategory(Request $request): Response {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category->setSlug($category->getName());
            $category->setCreatedAt(new \DateTime());
            $this->em->persist($category);
            $this->em->flush();
            return $this->redirectToRoute('getCategories');
        }
        return $this->render('category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function updateCategory(Request $request ,int $id): Response {

        $category = $this->em->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('getCategories');
        }
        return $this->render('category/update.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function deleteCategory(int $id): Response {
        $category = $this->em->getRepository(Category::class)->find($id);
        $this->em->remove($category);
        $this->em->flush();
        return $this->redirectToRoute('getCategories');
    }
}
