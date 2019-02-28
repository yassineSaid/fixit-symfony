<?php

namespace BackBundle\Controller;

use MainBundle\Entity\Langue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LangueController extends Controller
{
    public function listAction()
    {
        $connect=$this->getDoctrine()->getManager();
        $langues=$connect->getRepository(Langue::class)->findAll();
        return $this->render('@Back/Langue/liste.html.twig',array(
            "langues"=>$langues
        ));
    }
    public function supprimerAction($id)
    {
        $connect=$this->getDoctrine()->getManager();
        $langue=$connect->getRepository(Langue::class)->find($id);
        $connect->remove($langue);
        $connect->flush();
        return $this->redirectToRoute('admin_langues');
    }
    public function ajouterAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $langues=$connect->getRepository(Langue::class)->findAll();
        if ($request->isMethod('post'))
        {
            $em=$this->getDoctrine()->getManager();
            $l=$em->getRepository(Langue::class)->findByLibelle($request->get('libelle'));
            if ($l[0]==0)
            {
                $langue=new Langue();
                $langue->setLibelle($request->get('libelle'));
                $connect=$this->getDoctrine()->getManager();
                $connect->persist($langue);
                $connect->flush();
            }
            else
            {
                return $this->render('@Back/Langue/liste.html.twig',array(
                    "langues"=>$langues,
                    "erreur"=>"erreur"
                ));
            }
        }
        return $this->render('@Back/Langue/liste.html.twig',array(
            "langues"=>$langues
        ));
    }
}
