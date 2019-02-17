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
            $em1=$this->getDoctrine()->getManager();
            $categorie1=$em1->getRepository(CategorieOutils::class)->find($request->get("inputCategorie"));
            $categorie1->setNbrOutil($categorie1->getNbrOutil()+1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($outil);
            $em->flush();
            //return $this->render('@CalendrierMedecins/Patient/Ajout.html.twig',array("medecin"=>$medecins));
            return $this->redirectToRoute("main_ajouterOutil");
        }
        return $this->render('@Back/Outil/ajouter.html.twig',array("categorie"=>$categorie));
    }
    public function ListeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->findAll();
        return $this->render('@Back/Outil/list.html.twig',array("outil"=>$outil));

    }
    public function modifierAction(Request $request)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieOutils")->findAll();
        $id=$_GET['id'];
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->find($id);
        if ($request->isMethod("POST"))
        {
            $connexion1=$this->getDoctrine();
            $outil->setNom($request->get("inputNom"));
            $outil->setQuantite($request->get("inputQuantite"));
            $outil->setDureeMaximale($request->get("inputDuree"));
            $outil->setPrix($request->get("inputPrix"));
            $outil->setCategorieOutils($connexion1->getRepository("MainBundle:CategorieOutils")->find($request->get("inputCategorie")));
            $em->flush();
            return $this->redirectToRoute("main_listOutil");
        }
        return $this->render("@Back/Outil/modifier.html.twig",array("outil"=>$outil,"categorie"=>$categorie));
    }
    public function SupprimerAction(Request $request)
    {

        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $id=$_GET['id'];
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->find($id);
        $em->remove($outil);
        $em->flush();
        return $this->redirectToRoute("main_listOutil");
    }
    public function afficherFrontAction(Request $request)
    {


        return $this->render("@Front/Outil/liste.html.twig");
    }

}
