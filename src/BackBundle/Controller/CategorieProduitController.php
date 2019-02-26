<?php

namespace BackBundle\Controller;

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
            $categorie->setDescription($request->get("description"));
            $em=$this->getDoctrine()->getManager();
            $file=$request->files->get("inputImage");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $categorie->setImage($fileName);
            $file->move(
                $this->getParameter('categorieProduit_directory'),
                $fileName);
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute("main_listCategorie_Produit");

        }

        return $this->render("@Back/CategorieProduit/CategorieProduit.html.twig");

    }
    public function ListerAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieProduit::class)->findAll();
        return $this->render('@Back/CategorieProduit/listCategorieProduit.html.twig',array("categorie"=>$categorie));

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
            $image = $categorie->getImage();
            if($image!=null)
            {unlink($this->getParameter('categorieProduit_directory').'/'.$image);}
            $file=$request->files->get("inputImage");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $categorie->setImage($fileName);
            $file->move(
                $this->getParameter('categorieProduit_directory'),
                $fileName
            );
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('main_listCategorie_Produit');
        }
        return $this->render('@Back/CategorieProduit/modifierCategorieProduit.html.twig');
    }
    public function supprimerAction($cat)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieProduit::class)->find($cat);
        $image = $categorie->getImage();
        if($image!=null)
        {unlink($this->getParameter('categorieProduit_directory').'/'.$image);}
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("main_listCategorie_Produit");
    }

}
