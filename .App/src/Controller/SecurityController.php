<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\LoginForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;

final class SecurityController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    private AuthenticationUtils $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function loginAction(): Response
    {
        $form = $this->createForm(LoginForm::class, [
            'email' => $this->authenticationUtils->getLastUsername(),

        ]);

        return $this->render('security/login.html.twig', [
            'last_username' => $this->authenticationUtils->getLastUsername(),
            'form' => $form->createView(),
            'error' => $this->authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/admin/logout", name="admin_logout")
     */
    public function logoutAction(): void
    {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

        // Left empty intentionally because this will be handled by Symfony.
    }
}