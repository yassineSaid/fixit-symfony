<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\Avis;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $avis=$em->getRepository(Avis::class)->findAvis($this->getUser()->getId());
        $categorie=$em->getRepository("MainBundle:CategorieService")->findAll();
        $service=$em->getRepository("MainBundle:Service")->findAll();
        $lastfiveratings=$em->getRepository(Avis::class)->findfivelastAvis($this->getUser()->getId());
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
            return $this->render('@Front/Default/index.html.twig',array("note"=>$avis,"lastavis"=>$lastfiveratings,"service"=>$service,"categorie"=>$categorie));
        }
        else {


            $Avis = new Avis();
            if ($request->isMethod('POST')) {

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

            return $this->render('@Front/Default/index.html.twig', array("lastavis" => $lastfiveratings,"service"=>$service,"categorie"=>$categorie));
        }

    }


}
