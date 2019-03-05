<?php

namespace BackBundle\Controller;

use MainBundle\Entity\Candidature;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CandidatureController extends Controller
{
    public function afficherAction()
    {
        $em=$this->getDoctrine()->getManager();
        $candidature=$em->getRepository(Candidature::class)->findAll();
        return $this->render('@Back/Candidature/liste.html.twig',array("candidature"=>$candidature));
    }
    public function supprimerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $candidature=$em->getRepository(Candidature::class)->find($id);
        $em->remove($candidature);
        $em->flush();
        return $this->redirectToRoute("candidat");
    }
}
