<?php

namespace WebServicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use MainBundle\Entity\RealisationService;
use MainBundle\Entity\Reclamation;
use MainBundle\Entity\Service;
use MainBundle\Entity\User;

class ReclamationWSController extends Controller
{
    public function getUserReclameAction($idUser)
    {
        $em=$this->getDoctrine()->getManager();
        $userReal=$em->getRepository(RealisationService::class)->findUsersReclame($idUser);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($userReal);
        return new JsonResponse($formatted);
    }
    public function getServiceRealiseAction($idUser,$idUserDemandeur)
    {
        $em=$this->getDoctrine()->getManager();
        $serviceReal=$em->getRepository(RealisationService::class)->findServicesRealise($idUser,$idUserDemandeur);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($serviceReal);
        return new JsonResponse($formatted);
    }
    public function getDateRealisationAction($idUserOffreur,$idUserDemandeur,$idService)
    {
        $em=$this->getDoctrine()->getManager();
        $serviceReal=$em->getRepository(RealisationService::class)->findDateRealisation($idUserOffreur,$idUserDemandeur,$idService);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($serviceReal);
        return new JsonResponse($formatted);
    }
    public function AjouterReclamationAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation= new Reclamation();

            $iduser=intval($request->get("UserAReclamer"));
            $userr=$em->getRepository(User::class)->find($iduser);

            $user=$em->getRepository(User::class)->find(intval($request->get("user")));

            $service=$em->getRepository(Service::class)->find(intval($request->get("service")));

            $reclamation->setUserreclame($userr);
            $reclamation->setServicerealise($service);
        $to = new \DateTime($request->get("dateRealisation"));
            $reclamation->setDateRealisation($to);
            $reclamation->setObject($request->get("Object"));
            $reclamation->setDescription($request->get("Description"));
            $dater=new \DateTime();
            $reclamation->setDateReclamation($dater);
            $reclamation->setUser($user);
            $reclamation->setSeen(0);
            $reclamation->setTraite(0);
            $reclamation->setShow(0);
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return new JsonResponse("ok",200);
    }

    public function afficherReclamationsAction($idUser)
    {
        $em=$this->getDoctrine()->getManager();
        $recs=$em->getRepository(Reclamation::class)->findReclamation($idUser);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($recs);
        return new JsonResponse($formatted);
    }

}
