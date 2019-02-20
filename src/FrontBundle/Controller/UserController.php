<?php

namespace FrontBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use MainBundle\Entity\Langue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function profilAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $langues=$connect->getRepository(Langue::class)->findAll();
        return $this->render('@Front/User/dashboardprofilesetting.html.twig',array("langues"=>$langues));
    }

}
