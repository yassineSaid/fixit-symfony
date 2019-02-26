<?php

namespace UserBundle\Controller;

use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@User/Default/index.html.twig');
    }
    public function acheterProduit($idUser,$montant)
    {
        $connect=$this->getDoctrine()->getManager();
        $user=$connect->getRepository(User::class)->find($idUser);
        if ($user->getSolde()<$montant)
        {
            return false;
        }
        else
        {
            $user->setSolde($user->getSolde()-$montant);
            $connect->flush();
            return true;
        }
    }
}
