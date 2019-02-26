<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $em1=$this->getDoctrine()->getManager();
        $cat=$em->getRepository("MainBundle:CategorieService")->findAll();
        $nbr=$em1->getRepository("MainBundle:Service")->nbrByCat();
        var_dump($nbr);

        return $this->render('@Back/Default/index.html.twig',array("categorie"=>$cat,"nbr"=>$nbr));
    }
}
