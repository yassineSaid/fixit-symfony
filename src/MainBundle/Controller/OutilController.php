<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\CategorieOutils;
use MainBundle\Entity\Outils;

class OutilController extends Controller
{
    public function ajouterAction(Request $request)
    {

        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieOutils")->findAll();
        $outil = new Outils();
        if ($request->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $outil->setNom($request->get("inputNom"));
            $outil->setQuantite($request->get("inputQuantite"));
            $outil->setDureeMaximale($request->get("inputDuree"));
            $outil->setPrix($request->get("inputPrix"));
            $outil->setCategorieOutils($connexion1->getRepository("MainBundle:CategorieOutils")->find($request->get("inputCategorie")));
            $em=$this->getDoctrine()->getManager();
            $em->persist($outil);
            $em->flush();
            //return $this->render('@CalendrierMedecins/Patient/Ajout.html.twig',array("medecin"=>$medecins));
            return $this->redirectToRoute("main_ajouterOutil");
        }
        return $this->render('@Back/Outil/ajouter.html.twig',array("categorie"=>$categorie));
    }

}
