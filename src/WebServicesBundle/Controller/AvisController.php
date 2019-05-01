<?php

namespace WebServicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\Avis;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use MainBundle\Entity\User;
class AvisController extends Controller
{
    public function getAvisUserAction($idUser)
    {
        $em=$this->getDoctrine()->getManager();
        $avis=$em->getRepository(Avis::class)->findAvis($idUser);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($avis);
        return new JsonResponse($formatted);
    }

    public function modifierAvisAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $avis=$em->getRepository(Avis::class)->findAvis(intval($request->get("user")));
        //var_dump($avis);
        $avis[0]->setSatisfaction($request->get("satisfaction"));
        $avis[0]->setDescription($request->get("Description"));
        $avis[0]->setNote(intval($request->get("rating")));
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        return new JsonResponse("ok",200);
    }
    public function ajouterAvisAction(Request $request)
    {
        $Avis = new Avis();

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find(intval($request->get("user")));
            $Avis->setUser($user);
            $Avis->setSatisfaction($request->get("satisfaction"));
            $Avis->setDescription($request->get("Description"));
            $Avis->setNote(intval($request->get("rating")));
            $user->setSolde($user->getSolde()+2);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Avis);
            $em->flush();
            return new JsonResponse("ok",200);


    }
}
