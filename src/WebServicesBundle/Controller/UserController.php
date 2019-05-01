<?php

namespace WebServicesBundle\Controller;

use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserController extends Controller
{
    public function getUserAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $user=$connect->getRepository(User::class)->getPassword($request->get("email"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function getUserByIdAction(Request $request)
    {
        $connect=$this->getDoctrine()->getManager();
        $user=$connect->getRepository(User::class)->find($request->get("id"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function modifierUserAction(Request $request)
    {
        if ($request->isMethod("post")) {
            $connect = $this->getDoctrine()->getManager();
            $user = $connect->getRepository(User::class)->find($request->get("id"));
            $user->setFirstname($request->get("firstname"));
            $user->setLastname($request->get("lastname"));
            $user->setAddress($request->get("address"));
            $connect->persist($user);
            $connect->flush();
            return new JsonResponse(200);
        }
        return new JsonResponse(500);
    }
}
