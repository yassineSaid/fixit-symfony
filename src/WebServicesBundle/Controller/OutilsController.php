<?php

namespace WebServicesBundle\Controller;

use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\CategorieOutils;
use MainBundle\Entity\Outils;
use MainBundle\Entity\UserOutil;


class OutilsController extends Controller
{
    public function afficherWSAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->findAll();
        $em1=$this->getDoctrine()->getManager();
        $outil=$em1->getRepository(Outils::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($outil);
        return new JsonResponse($formatted);
    }

    public function outilDisponibleWSAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieOutils::class)->findAll();
        $em1=$this->getDoctrine()->getManager();
        $outil=$em1->getRepository(Outils::class)->outilDisponible();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($outil);
        return new JsonResponse($formatted);
    }
    public function detailWSAction(Request $request)
    {
        $id=intval($request->get('outil'));
        $user=intval($request->get('user'));
        $em=$this->getDoctrine()->getManager();
        $em1=$this->getDoctrine()->getManager();
        $em2=$this->getDoctrine()->getManager();
        $outil=$em->getRepository(Outils::class)->find($id);
        $userOutil=$em2->getRepository(UserOutil::class)->premierOutilDQL($id);
        $userOutil2=$em1->getRepository(UserOutil::class)->location($outil,$user);

        if($outil->getQuantite()>0)
        {
            if($userOutil2==null)
            {
                return new JsonResponse(200);
            }
            else
            {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($userOutil2);
                return new JsonResponse($formatted);
            }
        }
        else
        {
            if($userOutil==null)
            {

                return new JsonResponse("ko");
            }
            elseif ($userOutil2!=null)
            {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($userOutil2);
                return new JsonResponse($formatted);
            }
            else
            {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($userOutil);
                return new JsonResponse($formatted);
            }
        }

    }
    public function louerWSAction(Request $request)
    {
        $idOutil=intval($request->get('outil'));
        $iduser=intval($request->get('user'));

            $connect1=$this->getDoctrine()->getManager();
            $connect2=$this->getDoctrine()->getManager();
            $connect3=$this->getDoctrine()->getManager();
            $outil=$connect3->getRepository(Outils::class)->find($idOutil);
            $user=$connect2->getRepository(User::class)->find($iduser);
            $outil->setQuantite($outil->getQuantite()-1);
            $user->setSolde($user->getSolde()-(intval($request->get("total"))));
            $userOutil=new UserOutil();
            $userOutil->setIdUser($user);
            $userOutil->setIdOutil($outil);
            $userOutil->setDateLocation(new \DateTime($request->get("dateLocation")));
            $userOutil->setDateRetour(new \DateTime($request->get("dateRetour")));
            $userOutil->setTotal(intval($request->get("total")));
            $connect1->persist($userOutil);
            $connect1->flush();
        return new JsonResponse(200);

    }
    public function rechercheOutilWSAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $outil=$connect->getRepository(Outils::class)->listOutils($request->get("nom"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($outil);
        return new JsonResponse($formatted);
    }
}
