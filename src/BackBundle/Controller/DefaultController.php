<?php

namespace BackBundle\Controller;

use MainBundle\Entity\Langue;
use MainBundle\Entity\Paiement;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $em1=$this->getDoctrine()->getManager();
        $cat=$em->getRepository("MainBundle:CategorieService")->findAll();
        $nbr=$em1->getRepository("MainBundle:Service")->nbrByCat();


        $connect=$this->getDoctrine()->getManager();
        $statAnnee=$connect->getRepository(Paiement::class)->statAnnee();
        $revenusAnnee=$connect->getRepository(Paiement::class)->venteCetteAnnee();
        $revenusTotal=$connect->getRepository(Paiement::class)->venteTotal();
        $visitorsToday=$connect->getRepository(User::class)->visitorsToday();
        $languesParlees=$connect->getRepository(Langue::class)->languesParlees();
        //var_dump($statAnnee);
        return $this->render('@Back/Default/index.html.twig',array(
            "categorie"=>$cat,
            "nbr"=>$nbr,
            "statAnnee"=>$statAnnee,
            "revenusAnnee"=>$revenusAnnee,
            "revenusTotal"=>$revenusTotal,
            "visitorsToday"=>$visitorsToday,
            "languesParlees"=>$languesParlees
        ));
    }
}
