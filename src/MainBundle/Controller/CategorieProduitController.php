<?php

namespace MainBundle\Controller;

use MainBundle\Entity\CategorieProduit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieProduitController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $categorie= new CategorieProduit();
        if ($request->isMethod("POST"))
        {
            $categorie->setNom($request->get("categorie"));
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute("main_ajouterCategori_Produit");
        }

        return $this->render("@Back/CategorieProduit/CategorieProduit.html.twig");

    }
}
