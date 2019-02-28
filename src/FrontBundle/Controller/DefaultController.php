<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\Avis;
use MainBundle\Entity\AchatProduit;
use MainBundle\Entity\User;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        if($this->getUser()==null)
        {
            $avis=null;
        }
        else
        {
            $avis=$em->getRepository(Avis::class)->findAvis($this->getUser()->getId());
        }
        $categorie=$em->getRepository("MainBundle:CategorieService")->findAll();
        $service=$em->getRepository("MainBundle:Service")->findAll();
        $lastfiveratings=$em->getRepository(Avis::class)->findfivelastAvis();
        if($avis!=null)
        {

            if($request->isMethod('POST'))
            {
                $avis[0]->setSatisfaction($request->get("satisfaction"));
                $avis[0]->setDescription($request->get("Description"));
                $avis[0]->setNote($request->get("rating"));
                $em=$this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('@Front/Default/index.html.twig',array("note"=>$avis,"lastavis"=>$lastfiveratings,"service"=>$service,"categorie"=>$categorie));
            }
            $em1 = $this->getDoctrine()->getManager();
            $prod = $em1->getRepository(AchatProduit::class)->TopDQL();
            return $this->render('@Front/Default/index.html.twig',array("note"=>$avis,"lastavis"=>$lastfiveratings,"service"=>$service,"categorie"=>$categorie,"produits"=>$prod));
        }
        else {


            $Avis = new Avis();
            if ($request->isMethod('POST')) {
                if($this->getUser()==null)
                {
                    $this->redirectToRoute('login');
                }
                $this->getUser()->setSolde($this->getUser()->getSolde()+2);
                $em = $this->getDoctrine()->getManager();
                $iduser = $this->getUser()->getId();
                $user = $em->getRepository(User::class)->find($iduser);
                $Avis->setUser($user);
                $Avis->setSatisfaction($request->get("satisfaction"));
                $Avis->setDescription($request->get("Description"));
                $Avis->setNote($request->get("rating"));
                $em = $this->getDoctrine()->getManager();
                $em->persist($Avis);
                $em->flush();


            }
            $em1 = $this->getDoctrine()->getManager();
            $prod = $em1->getRepository(AchatProduit::class)->TopDQL();


            return $this->render('@Front/Default/index.html.twig', array("lastavis" => $lastfiveratings,"service"=>$service,"categorie"=>$categorie,"produits"=>$prod));
        }

    }


}
