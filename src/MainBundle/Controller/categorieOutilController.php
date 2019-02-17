<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\CategorieOutils;

class CategorieOutilController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $categorie= new CategorieOutils();
        if ($request->isMethod("POST"))
        {
            $categorie->setNom($request->get("inputNom"));
            $categorie->setNbrOutil(0);
            var_dump($categorie);
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute("main_ajouterCategorieOutil");
        }
        var_dump($categorie);
        return $this->render("@Back/categorieOutil/ajouterCategorie.html.twig");
    }
    public function ListeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->findAll();
        return $this->render('@Back/categorieOutil/list.html.twig',array("categorie"=>$categorie));

    }
}
