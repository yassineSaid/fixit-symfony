<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
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
            $file=$request->files->get("inputLogo");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $categorie->setLogo($fileName);
            $file->move(
                $this->getParameter('categorieOutil_directory'),
                $fileName
            );
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute("back_listCategorieOutil");
        }
        return $this->render("@Back/categorieOutil/ajouterCategorie.html.twig");
    }
    public function ListeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->listeCategorie();
        return $this->render('@Back/categorieOutil/list.html.twig',array("categorie"=>$categorie));

    }
    public function modifierAction(Request $request)
    {

        $id=$_GET['id'];
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->find($id);
        if ($request->isMethod("POST"))
        {
            $categorie->setNom($request->get("inputNom"));
            $image = $categorie->getLogo();
            if($image!=null)
            {unlink($this->getParameter('categorieOutil_directory').'/'.$image);}
            $file=$request->files->get("inputLogo");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $categorie->setLogo($fileName);
            $file->move(
                $this->getParameter('categorieOutil_directory'),
                $fileName
            );
            $em->flush();
            return $this->redirectToRoute("back_listCategorieOutil");
        }
        return $this->render("@Back/categorieOutil/modifier.html.twig",array("categorie"=>$categorie));
    }
    public function SupprimerAction(Request $request)
    {
        $id=$_GET['id'];
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->find($id);
        $image = $categorie->getLogo();
        if($image!=null)
        {unlink($this->getParameter('categorieOutil_directory').'/'.$image);}
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("back_listCategorieOutil");
    }
}
