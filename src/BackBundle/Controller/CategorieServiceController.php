<?php

namespace BackBundle\Controller;

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
            $file=$request->files->get("image");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $categorie->setImageCategorie($fileName);
            $file->move(
                $this->getParameter('categorieService_directory'),
                $fileName
            );
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
        //$id=$_GET['id']
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieService::class)->find($id);
        if ($r->isMethod("POST"))
        {
            $categorie->setNom($r->get("Nom"));
            $categorie->setDescription($r->get("Description"));
            $image = $categorie->getImageCategorie();
            if($image!=null)
            {unlink($this->getParameter('categorieService_directory').'/'.$image);}
            $file=$r->files->get("image");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $categorie->setImageCategorie($fileName);
            $file->move(
                $this->getParameter('categorieService_directory'),
                $fileName
            );
            $em->flush();
            return $this->redirectToRoute("back_afficherCategorieService");
        }
        return $this->render("@Back/CategorieService/modifierCategorieService.html.twig",array("categorie"=>$categorie));

    }
    public function SupprimerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieService::class)->find($id);
        $image = $categorie->getImageCategorie();
        if($image!=null)
        {unlink($this->getParameter('categorieService_directory').'/'.$image);}
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("back_afficherCategorieService");
    }

}
