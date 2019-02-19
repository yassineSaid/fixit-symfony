<?php

namespace FrontBundle\Controller;

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
            try{
                $connect=$this->getDoctrine()->getManager();
                $userLangue=new UserLangue();
                $userLangue->setIdUser($request->get('idUser'));
                $userLangue->setIdLangue($request->get('idLangue'));
                $connect->persist($userLangue);
                //$connect->flush();
                return new Response("OK",200);
            }
            catch (Exception $e)
            {
                return new Response($this->get('session')->setFlash('flash_key',"Add not done: " . $e->getMessage()));
            }
            //var_dump($langues);
        }
        return false;
    }
}
