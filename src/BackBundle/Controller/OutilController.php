<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
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
            $outil->setAdresse($request->get("inputAdresse"));
            $outil->setCodePostal($request->get("inputCodePostal"));
            $outil->setVille($request->get("inputVille"));
            $outil->setCategorieOutils($connexion1->getRepository("MainBundle:CategorieOutils")->find($request->get("inputCategorie")));
            $file=$request->files->get("inputImage");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $outil->setImage($fileName);
            $file->move(
                $this->getParameter('outil_directory'),
                $fileName
            );
            $em=$this->getDoctrine()->getManager();
            $em->persist($outil);
            $em->flush();
            //return $this->render('@CalendrierMedecins/Patient/Ajout.html.twig',array("medecin"=>$medecins));
            return $this->redirectToRoute("back_listOutil");
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
            $outil->setAdresse($request->get("inputAdresse"));
            $outil->setCodePostal($request->get("inputCodePostal"));
            $outil->setVille($request->get("inputVille"));
            $outil->setCategorieOutils($connexion1->getRepository("MainBundle:CategorieOutils")->find($request->get("inputCategorie")));
            $image = $outil->getImage();
            if($image!=null)
            {unlink($this->getParameter('outil_directory').'/'.$image);}
            $file=$request->files->get("inputImage");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $outil->setImage($fileName);
            $file->move(
                $this->getParameter('outil_directory'),
                $fileName
            );
            $em->flush();
            return $this->redirectToRoute("back_listOutil");
        }
        return $this->render("@Back/Outil/modifier.html.twig",array("outil"=>$outil,"categorie"=>$categorie));
    }
    public function SupprimerAction(Request $request)
    {
        $id=$_GET['id'];
        $em=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->find($id);
        $image = $outil->getImage();
        if($image!=null)
        {unlink($this->getParameter('outil_directory').'/'.$image);}
        $em->remove($outil);
        $em->flush();
        return $this->redirectToRoute("back_listOutil");
    }


}
