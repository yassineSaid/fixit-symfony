<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\User;
use MainBundle\Entity\Candidature;
use Symfony\Component\HttpFoundation\Request;
class CandidatureController extends Controller
{
    public function ajouterAction(Request $request, $id)
    {
        $candidature = new candidature();
        if ($request->isMethod("POST"))
        {
            $em=$this->getDoctrine()->getManager();
            $iduser=$this->getUser()->getId();
            $user=$em->getRepository(User::class)->find($iduser);
            $candidature->setUser($user);
            $annonce=$em->getRepository(Annonce::class)->find($id);
            $candidature->setMessage($request->get("message"));
            $candidature->setEmail($request->get("email"));
            $candidature->setTel($request->get("tel"));
            $candidature->setEtat('En attente');
            $candidature->setAnnonce($annonce);
            $candidature->setDate(new \DateTime($request->get("date")));
            $em=$this->getDoctrine()->getManager();
            $em->persist($candidature);
            $em->flush();
            return $this->redirectToRoute("listeDem");
        }
        return $this->render('@Front/Candidature/postuler.html.twig');
    }
    public function modifierAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $candidature=$em->getRepository(Candidature::class)->find($id);
        if ($request->isMethod("POST"))
        {

            $candidature->setMessage($request->get("message"));
            $dater=new \DateTime();
            $candidature->setDate($dater);
            $em->flush();
            return $this->redirectToRoute("mesCandidatures");
        }
        return $this->render("@Front/Candidature/modifier.html.twig",array("annonce"=>$candidature));
    }
    public function mesCandidaturesAction()
        {

            $em=$this->getDoctrine()->getManager();
            $candidatures=$em->getRepository(Candidature::class)->findCandidature($this->getUser()->getId());
            return $this->render('@Front/Candidature/mesCandidatures.html.twig',array("candidatures"=>$candidatures));
        }

    public function supprimerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $candidature=$em->getRepository(Candidature::class)->find($id);
        $em->remove($candidature);
        $em->flush();
        return $this->redirectToRoute("mesCandidatures");
    }
}
