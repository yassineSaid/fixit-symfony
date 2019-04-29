<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\RealisationService;
use MainBundle\Entity\Reclamation;
use MainBundle\Entity\Service;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReclamationFrontController extends Controller
{
    public function AjouterReclamationAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $recs=$em->getRepository(Reclamation::class)->findReclamation($this->getUser()->getId());
        $reclamation= new Reclamation();
        if($request->isMethod('POST'))
        {
            $iduser=intval($request->get("UserAReclamer"));
            $user=$em->getRepository(User::class)->find($iduser);
            $count=$em->getRepository(Reclamation::class)->findCountBann($iduser);
            $service=$em->getRepository(Service::class)->find($rec[0]->getService()->getId());
            if($count>=3)
            {
                $user->setEnabled(0);
            }
            $reclamation->setUserreclame($user);
            $reclamation->setServicerealise($service);
            $reclamation->setDateRealisation($rec[0]->getDateRealisation());
            $reclamation->setObject($request->get("Object"));
            $reclamation->setDescription($request->get("Description"));
            $dater=new \DateTime();
            $reclamation->setDateReclamation($dater);
            $reclamation->setUser($this->getUser());
            $reclamation->setSeen(0);
            $reclamation->setTraite(0);
            $reclamation->setShow(0);
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
        $recc=$em->getRepository(RealisationService::class)->findServiceRealise($this->getUser()->getId());
        //$user=$em->getRepository(RealisationService::class)->findAll();
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find(intval($rec));

        if($request->isMethod('POST'))
        {
            $service=$em->getRepository(Service::class)->find($recc[0]->getService()->getId());
            $reclamation->setServicerealise($service);
            $reclamation->setDateRealisation($recc[0]->getDateRealisation());
            $iduser=intval($request->get("UserAReclamer"));
            $user=$em->getRepository(User::class)->find($iduser);
            $reclamation->setUserreclame($user);
            $reclamation->setObject($request->get("Object"));
            $reclamation->setDescription($request->get("Description"));
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->redirectToRoute('main_reclamation_Ajout');
        }
        return $this->render('@Front/Reclamation/modifierReclamation.html.twig',array("user"=>$recc,"reclamation"=>$reclamation));
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
        return $this->redirectToRoute("main_reclamation_Ajout");
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
            return new JsonResponse(array("seen"=>$rec->getSeen(),"traite"=>$rec->getTraite()));
        }
        return false;

    }

    public function selectserviceareclamerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $serv = $em->getRepository("MainBundle:RealisationService");

        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $s = $serv->createQueryBuilder("q")
            ->where("q.idUserOffreur = :cat")
            ->setParameter("cat", $request->query->get("UserAReclamer"))
            ->getQuery()
            ->getResult();

        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($s as $a){
            $responseArray[] = array(
                "id" => $a->getId(),
                "nom" => $a->getNom()
            );
        }

        // Return array with structure of the neighborhoods of the providen city id
        return new JsonResponse($responseArray);
    }
}
