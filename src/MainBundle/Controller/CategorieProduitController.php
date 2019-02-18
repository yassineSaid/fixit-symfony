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
    public function ListerAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieProduit::class)->findAll();
        return $this->render('@Back/CategorieProduit/listCategProd.html.twig',array("recs"=>$categorie));

    }
    public function modifierAction($cat,Request $request)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieProduit::class)->find($cat);

        if($request->isMethod('POST'))
        {

            $categorie->setNom($request->get("categorie"));
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('main_listCategorie_Produit');
        }
        return $this->render('@Back/CategorieProduit/modifierCategorie.html.twig');
    }
    public function supprimerAction($cat)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieProduit::class)->find($cat);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("main_listCategorie_Produit");
    }

}
