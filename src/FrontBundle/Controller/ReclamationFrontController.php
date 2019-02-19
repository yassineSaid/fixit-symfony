<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\RealisationService;
use MainBundle\Entity\Reclamation;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReclamationFrontController extends Controller
{
    public function AjouterReclamationAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(RealisationService::class)->findServiceRealise($this->getUser()->getId());
        $recs=$em->getRepository(Reclamation::class)->findReclamation($this->getUser()->getId());
        $reclamation= new Reclamation();
        if($request->isMethod('POST'))
        {
            $iduser=intval($request->get("UserAReclamer"));
            $user=$em->getRepository(User::class)->find($iduser);
            $reclamation->setUserreclame($user);
            $reclamation->setObject($request->get("Object"));
            $reclamation->setDescription($request->get("Description"));
            $dater=new \DateTime();
            $reclamation->setDateReclamation($dater);
            $reclamation->setUser($this->getUser());
            $reclamation->setSeen(0);
            $reclamation->setTraite(0);
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('main_affiche_Detail_Reclamation',array("reclamation"=>$reclamation->getId()));
        }
        return $this->render('@Front/Reclamation/ajouterReclamation.html.twig',array('user'=>$rec,"reclamations"=>$recs));
    }

    public function AfficherDetailAction($reclamation)
    {
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find($reclamation);
        return $this->render('@Front/Reclamation/detailsReclamation.html.twig',array("reclamation"=>$rec));
    }

    public function ModifierReclamationAction($rec,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(RealisationService::class)->findAll();
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($rec);

        if($request->isMethod('POST'))
        {
            $iduser=intval($request->get("UserAReclamer"));
            $user=$em->getRepository(User::class)->find($iduser);
            $reclamation->setUserreclame($user);
            $reclamation->setObject($request->get("Object"));
            $reclamation->setDescription($request->get("Description"));
            $dater=new \DateTime();
            $reclamation->setDateReclamation($dater);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('main_affiche_Detail_Reclamation',array("reclamation"=>$reclamation->getId()));
        }
        return $this->render('@Front/Reclamation/modifierReclamation.html.twig',array("user"=>$user,"reclamation"=>$reclamation));
    }

    public function MesReclamationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $recs=$em->getRepository(Reclamation::class)->findReclamation($this->getUser()->getId());
        return $this->render('@Front/Reclamation/listReclamations.html.twig',array("reclamations"=>$recs));
    }

    public function SupprimerReclamationAction($rec)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($rec);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("main_mes_reclamation");
    }
    public function  ListRecAction(Request $request)
    {
        /*$em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find(16);
        var_dump($rec);*/
        if ($request->isXmlHttpRequest())
        {
            $em=$this->getDoctrine()->getManager();
            $rec=$em->getRepository(Reclamation::class)->find($request->get("id"));
            //$rec=$em->getRepository(Reclamation::class)->find(16);
            return new JsonResponse(array("seen"=>$rec->getSeen()));
        }
        return false;

    }
    public function ListSerAccAction()
    {
        $em=$this->getDoctrine()->getManager();
        $recs=$em->getRepository(RealisationService::class)->findAll();
        return $this->render('@Front/Reclamation/listserviceaccomplis.html.twig',array("services"=>$recs));
    }

}
