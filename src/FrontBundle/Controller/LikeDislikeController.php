<?php

namespace FrontBundle\Controller;

use MainBundle\Entity\LikeDislike;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Response;

class LikeDislikeController extends Controller
{
        public function AjouterLikeAction(Request $request)
        {
            if ($request->isXmlHttpRequest())
            {
                $em=$this->getDoctrine()->getManager();
                $user=$em->getRepository(User::class)->find($request->get('idUser'));
                $userl=$em->getRepository(User::class)->find($request->get('idUserl'));
                var_dump($user);
                $likedis=new LikeDislike();
                $likedis->setUserlike($user);
                $likedis->setUserliked($userl);
                $likedis->setLidis($request->get('like'));
                $em->persist($likedis);
                $em->flush();
                return new Response("OK",200);
            }
            return false;
        }

        public function NombreLikeAction(Request $request)
        {
            if ($request->isXmlHttpRequest())
            {
                $connect=$this->getDoctrine()->getManager();
                $nbr=$connect->getRepository(LikeDislike::class)->findlikesCounts($request->get('id'));
                return new JsonResponse(array("nbr"=>$nbr));

                //var_dump($langues);
            }
            return false;
        }

        public function removelikeAction(Request $request)
        {

            if ($request->isXmlHttpRequest())
            {
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository(LikeDislike::class)->findlikesdelete($request->get('idUser'), $request->get('idUserl'));
                return new Response("OK",200);
            }
            return false;
        }

        public function NombreDislikeAction(Request $request)
        {
            if ($request->isXmlHttpRequest())
            {
                $connect=$this->getDoctrine()->getManager();
                $nbr=$connect->getRepository(LikeDislike::class)->findDislikesCounts($request->get('id'));
                return new JsonResponse(array("nbrd"=>$nbr));
                //var_dump($langues);
            }
            return false;
        }

        public function verifyAction(Request $request)
        {
            if ($request->isXmlHttpRequest())
            {
                $em = $this->getDoctrine()->getManager();
                $like = $em->getRepository(LikeDislike::class)->findVerify($request->get('idUser'), $request->get('idUserl'));
                return new JsonResponse(array("like"=>$like));
            }
            return false;
        }

        public function removedislikeAction(Request $request)
        {
            if ($request->isXmlHttpRequest())
            {
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository(LikeDislike::class)->finddislikesdelete($request->get('idUser'), $request->get('idUserl'));
                return new Response("OK",200);
            }
            return false;
        }

        public function countcurrentAction(Request $request)
        {
            if ($request->isXmlHttpRequest())
            {
                $em = $this->getDoctrine()->getManager();
                $nbrl = $em->getRepository(LikeDislike::class)->findLikesCountsCurrent($request->get('id'));
                $nbrd = $em->getRepository(LikeDislike::class)->findDislikesCountsCurrent($request->get('id'));
                return new JsonResponse(array("nbrl"=>$nbrl,"nbrd"=>$nbrd));
            }
            return false;

        }
}
