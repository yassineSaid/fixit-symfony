<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\Avis;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\RealisationService;
use Symfony\Component\HttpFoundation\Request;

class AvisFrontController extends Controller
{
    public function NoterServiceAction(Request $request)
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

        return $this->render('@Front/Reclamation/noter.html.twig');
    }
}
