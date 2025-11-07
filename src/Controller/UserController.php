<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends AbstractController
{

    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function getUsers(): Response
    {
        $user = $this->em->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $user,
        ]);
    }

    public function addUser(Request $request): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $user->setRoles(['ROLE_USER']);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('getUsers');
        }
        return $this->render('user/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function updateUser(Request $request, int $id): Response {
        $user = $this->em->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('getUsers');
        }
        return $this->render('user/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function deleteUser(int $id): Response {
        $user = $this->em->getRepository(User::class)->find($id);
        $this->em->remove($user);
        $this->em->flush();
        return $this->redirectToRoute('getUsers');
    }
}
