<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\Service;

class ServiceController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        $service = new Service();
        if ($request->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $service->setNom($request->get("Nom"));
            $service->setCategorieService($connexion1->getRepository("MainBundle:CategorieService")->find($request->get("IdCat")));

            $em=$this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            return $this->redirectToRoute("main_ajouterService");
        }
        return $this->render('@Back/Service/ajouterService.html.twig',array("categorie"=>$categorie));
    }
    public function afficherAction()
    {
        $connexion=$this->getDoctrine();
        $service=$connexion->getRepository("MainBundle:Service")->findAll();
        return $this->render('@Back/Service/afficherService.html.twig',array("service"=>$service));
    }
    public function modifierAction(Request $r,$id)
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        $em=$this->getDoctrine()->getManager();
        $service=$em->getRepository(Service::class)->find($id);
        if ($r->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $service->setNom($r->get("Nom"));
            $service->setCategorieService($connexion1->getRepository("MainBundle:CategorieService")->find($r->get("IdCat")));
            $em->flush();
            return $this->redirectToRoute("main_afficherService");
        }
        return $this->render("@Back/Service/modifierService.html.twig",array("service"=>$service,"categorie"=>$categorie));

    }
    public function supprimerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $service=$em->getRepository(Service::class)->find($id);
        $em->remove($service);
        $em->flush();
        return $this->redirectToRoute("main_afficherService");
    }

}
