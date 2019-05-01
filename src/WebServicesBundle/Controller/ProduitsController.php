<?php

namespace WebServicesBundle\Controller;

use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\Produit;
use MainBundle\Entity\AchatProduit;

class ProduitsController extends Controller
{
    public function afficherWSAction(Request $request)
    {
        $user=$request->get('idUser');
        $em1=$this->getDoctrine()->getManager();
        $produit=$em1->getRepository(Produit::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }
    public function MesProduitsWSAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Produit::class)->mesProduitsDQL($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prod);
        return new JsonResponse($formatted);
    }
    public function GetAllCategorieWSAction(Request $request){
        $connexion1 = $this->getDoctrine();
        $connexion = $this->getDoctrine();
        $categorie = $connexion->getRepository("MainBundle:CategorieProduit")->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorie);
        return new JsonResponse($formatted);
    }
    public function modifierProduitWSAction(Request $request)
    {

        $connexion = $this->getDoctrine();
        $categorie = $connexion->getRepository("MainBundle:CategorieProduit")->findAll();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(produit::class)->find($request->get("id"));
         $connexion1 = $this->getDoctrine();
            $produit->setNom($request->get("nom"));
            $produit->setQuantite($request->get("quantite"));
            $produit->setPrix($request->get("prix"));
            $produit->setCategorieProduit($connexion1->getRepository("MainBundle:CategorieProduit")->find($request->get("Categorie")));
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            //return $this->render('@CalendrierMedecins/Patient/Ajout.html.twig',array("medecin"=>$medecins));
            return new JsonResponse(200);

    }
    public function acheterWSAction(Request $request, $pro,$us,$quantite)
    {
       $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(produit::class)->find($pro);
        //$achat = new  AchatProduit();
        //$date=new \DateTime();

            $connect = $this->getDoctrine()->getManager();
            $user = $connect->getRepository(User::class)->find($us);
            $connect1 = $this->getDoctrine()->getManager();
        $connect2 = $this->getDoctrine()->getManager();
            $user1 = $connect->getRepository(User::class)->find($prod->getUser());;
            if ($quantite* $prod->getPrix() > $user->getSolde()) {
                return new JsonResponse(500);
            }
            else if ($quantite > $prod->getQuantite()){
                return new JsonResponse(300);

            }
            else {
                $user->setSolde($user->getSolde() - $quantite * $prod->getPrix());
                $user1->setSolde($user1->getSolde() + $quantite * $prod->getPrix());
                $connect->flush();
                $connect1->flush();
                $prod->setQuantite($prod->getQuantite() - $quantite);
                $em->flush();
                /*
                $achat->setPrix($quantite * $prod->getPrix());
                $achat->setIdProduit($prod->getId());
                $achat->setDate($date);
                $achat->setQuantite($quantite);
                $achat->setIdAcheteur($this->getUser()->getId());
                $achat->setAcheteur($user);
                $achat->setProduit($prod->getNom());
                $achat->setImage($prod->getImage());
                $connect2->persist($achat);
                $connect2->flush();*/
                return new JsonResponse(200);
            }
    }
}
