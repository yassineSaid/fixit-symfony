<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Back/Default/index.html.twig');
    }
    public function loginAction()
    {
        return $this->render('@Back/Default/Login.html.twig');
    }
}
