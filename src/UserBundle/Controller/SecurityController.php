<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends Controller
{
    private $tokenManager;
    public function __construct(CsrfTokenManagerInterface $tokenManager = null)
    {
        $this->tokenManager = $tokenManager;
    }
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
        /** @var $session Session */
        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');

        if ($authChecker->isGranted('ROLE_SUPER_ADMIN')) {
            return new RedirectResponse($router->generate('back_homepage'), 307);
        }

        if ($authChecker->isGranted('ROLE_USER')) {
            return new RedirectResponse($router->generate('front_homepage'), 307);
        }
        $session = $request->getSession();
        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;
        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }
        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }
        // last username entered by the user
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);
        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;
        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'form' => $form->createView()
        ));
    }
    public function checkAction()
    {
        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');
        if ($authChecker->isGranted('ROLE_SUPER_ADMIN')) {
            return new RedirectResponse($router->generate('back_homepage'), 307);
        }

        else if ($authChecker->isGranted('ROLE_USER')) {
            return new RedirectResponse($router->generate('front_homepage'), 307);
        }

        else {
            return new RedirectResponse($router->generate('front_homepage'), 307);
        }
    }
    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
    {
        //var_dump($_GET['registration']);
        if (isset($_GET['registration']))
        {
            $ar=array('registrationFailure'=>true);
            $data=$data+$ar;
        }
        else
        {
            $ar=array('registrationFailure'=>false);
            $data=$data+$ar;
        }
        $requestAttributes = $this->container->get('router.request_context')->getPathInfo();
        if ($requestAttributes=="/admin/login")
        {
            return $this->render('@Back/Default/login.html.twig',$data);
        }
        else
        {
            return $this->render('@Front/User/login.html.twig',$data);
        }

    }
}
