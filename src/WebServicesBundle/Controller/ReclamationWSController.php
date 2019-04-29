<?php

namespace WebServicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use MainBundle\Entity\RealisationService;

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

}
