<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\Avis;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Repository\AvisRepository;
use Symfony\Component\HttpFoundation\Request;

class AvisFrontController extends Controller
{
    public function NoterServiceAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $avis=$em->getRepository(Avis::class)->findAvis($this->getUser()->getId());
        $categorie=$em->getRepository("MainBundle:CategorieService")->findAll();
        $service=$em->getRepository("MainBundle:Service")->findAll();
        if($avis!=null)
        {

            if($request->isMethod('POST'))
            {
                $avis[0]->setSatisfaction($request->get("satisfaction"));
                $avis[0]->setDescription($request->get("Description"));
                $avis[0]->setNote($request->get("rating"));
                $em=$this->getDoctrine()->getManager();
                $em->flush();
                return $this->render('@Front/Reclamation/noter.html.twig',array("note"=>$avis));
            }
            return $this->render('@Front/Reclamation/noter.html.twig',array("note"=>$avis));
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
                $this->getUser()->setSolde($this->getUser()->getSolde()+2);
                $em = $this->getDoctrine()->getManager();
                $em->persist($Avis);
                $em->flush();


            }
            return $this->render('@Front/Reclamation/noter.html.twig');
        }



    }

    public function NoterServiceindexAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $avis=$em->getRepository(Avis::class)->findAvis($this->getUser()->getId());
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
                return $this->render('@Front/Default/index.html.twig',array("note"=>$avis,"lastavis"=>$lastfiveratings));
            }
            return $this->render('@Front/Default/index.html.twig',array("note"=>$avis,"lastavis"=>$lastfiveratings));
        }
        else
        {


            $Avis= new Avis();
            if($request->isMethod('POST'))
            {

                $em=$this->getDoctrine()->getManager();
                $iduser=$this->getUser()->getId();
                $user=$em->getRepository(User::class)->find($iduser);
                $Avis->setUser($user);
                $Avis->setSatisfaction($request->get("satisfaction"));
                $Avis->setDescription($request->get("Description"));
                $Avis->setNote($request->get("rating"));
                $em=$this->getDoctrine()->getManager();
                $em->persist($Avis);
                $em->flush();

            }

            return $this->render('@Front/Default/index.html.twig',array("lastavis"=>$lastfiveratings));
        }

    }
}
