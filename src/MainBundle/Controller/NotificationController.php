<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends Controller
{
    public function displayAction()
    {
        $notification= $this->getDoctrine()->getManager()->getRepository('MainBundle:Notification')->findAll();
        return $this->render('@Main/Notification/notification.html.twig', array('notification'=>$notification));
    }
    public function  listAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $em=$this->getDoctrine()->getManager();
            $notification=$em->getRepository(Notification::class)->findAll();
            return new JsonResponse(array("notification"=>$notification));
        }
        return false;

    }
}
