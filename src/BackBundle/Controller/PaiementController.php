<?php

namespace BackBundle\Controller;

use MainBundle\Entity\Paiement;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PaiementController extends Controller
{
    public function listAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('@Back/Paiement/soldes.html.twig', array('users' =>   $users));
    }
    public function historiqueUserAction($id)
    {
        $connect=$this->getDoctrine()->getManager();
        $connect1=$this->getDoctrine()->getManager();
        $user=$connect1->getRepository(User::class)->find($id);
        $paiements=$connect->getRepository(Paiement::class)->paiementsUser($id);

        return $this->render('@Back/Paiement/historiquePaiement.html.twig', array('paiements'=>$paiements,'user'=>$user));
    }
}
