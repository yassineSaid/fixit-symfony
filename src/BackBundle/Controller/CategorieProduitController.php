<?php

namespace BackBundle\Controller;
use MainBundle\Entity\Produit;
use MainBundle\Entity\AchatProduit;
use MainBundle\Entity\CategorieProduit;
use MainBundle\Entity\ProduitLike;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieProduitController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $categorie= new CategorieProduit();
        $em=$this->getDoctrine()->getManager();
        $cate=$em->getRepository(CategorieProduit::class)->findAll();
        if ($request->isMethod("POST"))
        {
            foreach ($cate as $value)
            {
            if ($value->getNom()==$request->get('categorie'))
            {

                return $this->render("@Back/CategorieProduit/CategorieProduit.html.twig",array("error"=>"cette catégorie est existe deja "));

            }
            }

                $categorie->setNom($request->get("categorie"));
                $categorie->setDescription($request->get("description"));
                $em = $this->getDoctrine()->getManager();
                $file = $request->files->get("inputImage");
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
        $nom=$categorie->getNom();

        if($request->isMethod('POST'))
        {

            $categorie->setNom($nom);
            $categorie->setDescription($request->get("description"));
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
        return $this->render('@Back/CategorieProduit/modifierCategorieProduit.html.twig',array("nom"=>$nom));
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
    public function ListeAchatAction()
    {
        $em=$this->getDoctrine()->getManager();
        $achat=$em->getRepository(AchatProduit::class)->findAll();
        return $this->render('@Back/CategorieProduit/listAchat.html.twig',array("achat"=>$achat));

    }

    public function listeProduitAction()
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(produit::class)->findAll();

        return $this->render('@Back/CategorieProduit/listeProduit.html.twig', array(
            "produit" => $prod
        ));

    }
    public function SupprimerProduitAction($prod)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();
        $em1 = $this->getDoctrine()->getManager();
        $em1->getRepository(ProduitLike::class)->SupLikesDQL($prod);
        $produit = $em->getRepository(produit::class)->find($prod);
        $image = $produit->getImage();
        if ($image != null) {
            unlink($this->getParameter('produit_directory') . '/' . $image);
        }
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("List_Produit");
    }

}
