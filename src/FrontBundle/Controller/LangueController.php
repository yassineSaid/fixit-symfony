<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\Langue;
use MainBundle\Entity\UserLangue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use MainBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LangueController extends Controller
{
    public function listLanguesAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $connect=$this->getDoctrine()->getManager();
            $langues=$connect->getRepository(User::class)->listLangueUser($request->get('id'));
            return new JsonResponse(array("langues"=>$langues));
            //var_dump($langues);
        }
        return false;
    }
    public function ajouterAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $connect1=$this->getDoctrine()->getManager();
            $connect2=$this->getDoctrine()->getManager();
            $connect3=$this->getDoctrine()->getManager();
            $langue=$connect2->getRepository(Langue::class)->find($request->get('idLangue'));
            $user=$connect3->getRepository(User::class)->find($request->get('idUser'));
            $userLangue=new UserLangue();
            $userLangue->setIdUser($user);
            $userLangue->setIdLangue($langue);
            $connect1->persist($userLangue);
            $connect1->flush();
            return new Response("OK",200);
        }
        return false;
    }
    public function supprimerAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $connect1=$this->getDoctrine()->getManager();
            $connect1->getRepository(UserLangue::class)->deleteLangueUser($request->get("idUser"),$request->get("idLangue"));
            return new Response("OK",200);
        }
        return false;
    }
}
