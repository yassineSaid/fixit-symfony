<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        $service=$connexion->getRepository("MainBundle:Service")->findAll();
       // $group=$connexion->getRepository("MainBundle:Service")->groupByCat();
        return $this->render('@Front/Default/index.html.twig',array("service"=>$service,"categorie"=>$categorie));
    }


}
