<?php

namespace MainBundle\Controller;

use MainBundle\Entity\RealisationService;
use MainBundle\Entity\Reclamation;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReclamationController extends Controller
{
    public function AjouterReclamationAction(Request $request)
    {
        if ($this->getUser()==null)
        {
             return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(RealisationService::class)->findAll();
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
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('main_affiche_Detail_Reclamation',array("reclamation"=>$reclamation->getId()));
        }
        return $this->render('@Front/User/AjouterReclamation.html.twig',['user'=>$rec]);
    }

    public function AfficherDetailAction($reclamation)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find($reclamation);
        return $this->render('@Front/User/AfficherDetailReclamation.html.twig',array("reclamation"=>$rec));
    }

    public function ModifierReclamationAction($rec,Request $request)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
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
        return $this->render('@Front/User/ModifierReclamation.html.twig',array("user"=>$user,"reclamation"=>$reclamation));
    }

    public function MesReclamationAction()
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $recs=$em->getRepository(Reclamation::class)->findReclamation($this->getUser()->getId());
        return $this->render('@Front/User/MesReclamations.html.twig',array("reclamations"=>$recs));
    }

    public function SupprimerReclamationAction($rec)
    {
        if ($this->getUser()==null)
        {
            return $this->redirectToRoute('login');
        }
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($rec);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("main_mes_reclamation");
    }

}
