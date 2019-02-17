<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\CategorieService;

class CategorieServiceController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $categorie= new CategorieService();
        if ($request->isMethod("POST"))
        {

            $categorie->setNom($request->get("Nom"));
            $categorie->setDescription($request->get("Description"));
            var_dump($categorie);
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

           // $this->redirectToRoute("main_ajouterCategorieService");
        }

        return $this->render("@Back/CategorieService/ajouterCategorieService.html.twig");


    }
    public function afficherAction()
    {
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieService")->findAll();
        return $this->render('@Back/CategorieService/afficherCategorieService.html.twig',array("categorie"=>$categorie));
    }
    public function modifierAction(Request $r,$id)
    {
        //$id=$_GET['id'];
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieService::class)->find($id);
        if ($r->isMethod("POST"))
        {
            $categorie->setNom($r->get("Nom"));
            $categorie->setDescription($r->get("Description"));
            $em->flush();
            return $this->redirectToRoute("main_afficherCategorieService");
        }
        return $this->render("@Back/CategorieService/modifierCategorieService.html.twig",array("categorie"=>$categorie));

    }
    public function SupprimerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieService::class)->find($id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("main_afficherCategorieService");
    }
}
