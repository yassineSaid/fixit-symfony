<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\Annonce;

class AnnonceController extends Controller
{
    public function afficherAction()
    {
        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository(Annonce::class)->findAll();
        return $this->render('@Back/Annonce/liste.html.twig',array("annonce"=>$annonce));
    }
        public function supprimerAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository(Annonce::class)->find($id);
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute("liste_annonce");
    }

    public function candidatAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository(Annonce::class)->find($id);

        return $this->render('@Back/Annonce/candidats.html.twig',array("annonce"=>$annonce));
    }
}
