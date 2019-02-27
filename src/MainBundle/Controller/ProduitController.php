<?php

 namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\Produit;

class ProduitController extends Controller
{
    public function ajouterAction(Request $request)
    {

        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieProduit")->findAll();
        $produit = new produit();
        if ($request->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $produit->setNom($request->get("nom"));
            $produit->setQuantite($request->get("quantite"));
            $produit->setPrix($request->get("prix"));
            $produit->setDateExp(new \DateTime($request->get("date")));
            $produit->setCategorieProduit($connexion1->getRepository("MainBundle:CategorieProduit")->find($request->get("Categorie")));
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            //return $this->render('@CalendrierMedecins/Patient/Ajout.html.twig',array("medecin"=>$medecins));
            return $this->redirectToRoute("main_ajouter_Produit");
        }
        return $this->render('@Front/produit/ajouterProduit.html.twig',array("categorie"=>$categorie));
    }
    public function MesProduitAction()
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $prod=$em->getRepository(produit::class)->findAll();
        return $this->render('@Front/Produit/mesProduit.html.twig',array("produit"=>$prod));
    }
    public function modifierAction($prod,Request $request)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieProduit")->findAll();
        $em = $this->getDoctrine()->getManager();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(produit::class)->find($prod);

        if ($request->isMethod('POST')) {
            $connexion1=$this->getDoctrine();
            $produit->setNom($request->get("nom"));
            $produit->setQuantite($request->get("quantite"));
            $produit->setPrix($request->get("prix"));
            $produit->setDateExp(new \DateTime($request->get("date")));
            $produit->setCategorieProduit($connexion1->getRepository("MainBundle:CategorieProduit")->find($request->get("Categorie")));
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            //return $this->render('@CalendrierMedecins/Patient/Ajout.html.twig',array("medecin"=>$medecins));
            return $this->redirectToRoute("main_mes_produit");
        }
        return $this->render('@Front/produit/modifieProduit.html.twig',array("categorie"=>$categorie));

        }


}
