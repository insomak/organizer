<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountType;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Yaml\Yaml;

class AccountController extends AbstractController
{
    #[Route('/konta/nowe', name: 'account_create')]
    #[IsGranted('ROLE_USER')] // Zabezpieczenie dostępu dla użytkowników z rolą ROLE_USER
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $account = new Account();

        // Ładowanie danych użytkowników z pliku config/users.yaml
        $usersFilePath = $this->getParameter('kernel.project_dir') . '/config/users.yaml';
        $data = Yaml::parseFile($usersFilePath);

        // Konwertowanie danych użytkowników do formatu (id => username)
        $users = [];
        foreach ($data['users'] as $user => $userInfo) {
            $users[$user] = $user; // Tworzymy pary (nazwa użytkownika => ID)
        }

        // Tworzymy formularz do dodawania konta
        $form = $this->createForm(AccountType::class, $account, ['users' => $users]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Zapisujemy dane do bazy
            $em->persist($account);
            $em->flush();

            $this->addFlash('success', 'Konto zostało dodane.');

            return $this->redirectToRoute('account_create'); // Przekierowanie po udanym dodaniu
        }

        return $this->render('account/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
