<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminController extends Controller
{
    public function listAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('@Back/Admin/users.html.twig', array('users' =>   $users));
    }
    public function upgradeAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(['id' => $id]);
        $router = $this->container->get('router');
        $user->addRole("ROLE_SUPER_ADMIN");
        $userManager->updateUser($user);
        return new RedirectResponse($router->generate('users_list'), 307);
    }
    public function downgradeAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(['id' => $id]);
        $router = $this->container->get('router');
        $user->removeRole("ROLE_SUPER_ADMIN");
        $userManager->updateUser($user);
        return new RedirectResponse($router->generate('users_list'), 307);
    }
}
