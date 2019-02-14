<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function profilAction()
    {
        return $this->render('@Front/User/dashboardprofilesetting.html.twig');
    }
}
