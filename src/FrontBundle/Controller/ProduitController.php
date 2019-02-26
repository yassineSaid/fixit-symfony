<?php

 namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\Produit;
use MainBundle\Entity\User;
use MainBundle\Entity\RealisationService;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends Controller
{
    public function ajouterAction(Request $request)
    {


        $connexion = $this->getDoctrine();
        $categorie = $connexion->getRepository("MainBundle:CategorieProduit")->findAll();
        $en = $this->getDoctrine()->getManager();
        $rec = $en->getRepository(RealisationService::class)->findAll();
        $produit = new produit();
        if ($request->isMethod("POST")) {

            $connexion1 = $this->getDoctrine();
            {

                $produit->setUser($this->getUser());
                $produit->setNom($request->get("nom"));
                $produit->setQuantite($request->get("quantite"));
                $produit->setPrix($request->get("prix"));
                $produit->setDateExp(new \DateTime($request->get("date")));
                $produit->setCategorieProduit($connexion1->getRepository("MainBundle:CategorieProduit")->find($request->get("categorie")));
                $file=$request->files->get("inputLogo");
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $produit->setImage($fileName);
                $file->move(
                    $this->getParameter('produit_directory'),
                    $fileName);
                $em = $this->getDoctrine()->getManager();
                $em->persist($produit);
                $em->flush();
                //return $this->render('@Front/Produit/ajouterProduit.html.twig');

            }
            return $this->redirectToRoute("main_mes_produit");
        }
        return $this->render('@Front/produit/ajouteProduit.html.twig', array("categorie" => $categorie, "user" => $rec));
    }
    public function MesProduitAction()
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $prod=$em->getRepository(produit::class)->findAll();
        return $this->render('@Front/produit/listerProduit.html.twig',array("produit"=>$prod));
    }
    public function modifierAction($prod,Request $request)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $connexion=$this->getDoctrine();
        $categorie=$connexion->getRepository("MainBundle:CategorieProduit")->findAll();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(produit::class)->find($prod);

        if ($request->isMethod('POST')) {
            $connexion1=$this->getDoctrine();
            $produit->setNom($request->get("nom"));
            $produit->setQuantite($request->get("quantite"));
            $produit->setPrix($request->get("prix"));
            $produit->setDateExp(new \DateTime($request->get("date")));
            $produit->setCategorieProduit($connexion1->getRepository("MainBundle:CategorieProduit")->find($request->get("Categorie")));
            $image = $produit->getImage();
            if($image!=null)
            {unlink($this->getParameter('produit_directory').'/'.$image);}
            $file=$request->files->get("inputLogo");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $produit->setImage($fileName);
            $file->move(
                $this->getParameter('produit_directory'),
                $fileName
            );
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            //return $this->render('@CalendrierMedecins/Patient/Ajout.html.twig',array("medecin"=>$medecins));
            return $this->redirectToRoute("main_mes_produit");
        }
        return $this->render('@Front/produit/modifieRProduit.html.twig',array("categorie"=>$categorie));

        }
    public function SupprimerAction($prod)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository(produit::class)->find($prod);
        $image = $produit->getImage();
        if($image!=null)
        {unlink($this->getParameter('produit_directory').'/'.$image);}
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("main_mes_produit");
    }
    public function DetaillAction($prod)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $prod=$em->getRepository(produit::class)->find($prod);
        return $this->render('@Front/produit/detailleProduit.html.twig',array("produit"=>$prod));
    }


}
