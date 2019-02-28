<?php
 namespace FrontBundle\Controller;


 use MainBundle\Entity\CategorieProduit;
 use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\Produit;
 use MainBundle\Entity\AchatProduit;
 use MainBundle\Entity\ProduitLike;
use MainBundle\Entity\User;
use MainBundle\Entity\RealisationService;
use Symfony\Component\HttpFoundation\Request;


class ProduitController extends Controller
{
    public function ajouterAction(Request $request)
    {

        $connexion1 = $this->getDoctrine();
        $connexion = $this->getDoctrine();
        $categorie = $connexion->getRepository("MainBundle:CategorieProduit")->findAll();
        $en = $this->getDoctrine()->getManager();
        $em = $this->getDoctrine()->getManager();
        $rec = $en->getRepository(RealisationService::class)->findAll();
        $produit = new produit();
        $cate=$em->getRepository(Produit::class)->findAll();
        if ($request->isMethod("POST")) {




                foreach ($cate as $value)
                {

                if ($value->getNom()==$request->get('nom'))
                 {
                        return $this->render('@Front/produit/ajouteProduit.html.twig',array("categorie" => $categorie,"error"=>"cette produit est existe deja "));

                 }

                }

                $produit->setUser($this->getUser());
                $produit->setNom($request->get("nom"));
                $produit->setQuantite($request->get("quantite"));
                $produit->setPrix($request->get("prix"));
                $produit->setDateExp(new \DateTime($request->get("date")));
                $produit->setCategorieProduit($connexion1->getRepository("MainBundle:CategorieProduit")->find($request->get("categorie")));
                $file = $request->files->get("inputLogo");
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $produit->setImage($fileName);
                $file->move(
                    $this->getParameter('produit_directory'),
                    $fileName);
                $em = $this->getDoctrine()->getManager();
                $em->persist($produit);
                $em->flush();
                //return $this->render('@Front/Produit/ajouterProduit.html.twig');


            return $this->redirectToRoute("main_mes_produit");

        }
        return $this->render('@Front/produit/ajouteProduit.html.twig', array("categorie" => $categorie, "user" => $rec));
    }

    public function listeAction(Request $r)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(produit::class)->findAll();
        $em = $this->getDoctrine()->getManager();
        $pro = $em->getRepository(AchatProduit::class)->TopDQL();
        $react_repo = $this->getDoctrine()->getRepository(ProduitLike::class);
        $reacts = $react_repo->findBy(array("user" => $this->getUser()));
        return $this->render('@Front/produit/listerProduit.html.twig', array(
            "produit" => $prod,
            "reacts" => $reacts,
            "pro"=>$pro
        ));

    }

    public function likeAction($id)
    {
        $prod_repo = $this->getDoctrine()->getRepository(produit::class);
        $prod = $prod_repo->find($id);
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $react = new ProduitLike();
            $react->setProduit($prod);
            $react->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($react);
            $em->flush();
            return $this->redirectToRoute("main_mes_produit");
        }
    }

    public function modifierAction($prod, Request $request)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $connexion = $this->getDoctrine();
        $categorie = $connexion->getRepository("MainBundle:CategorieProduit")->findAll();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(produit::class)->find($prod);

        if ($request->isMethod('POST')) {
            $connexion1 = $this->getDoctrine();
            $produit->setNom($request->get("nom"));
            $produit->setQuantite($request->get("quantite"));
            $produit->setPrix($request->get("prix"));
            $produit->setDateExp(new \DateTime($request->get("date")));
            $produit->setCategorieProduit($connexion1->getRepository("MainBundle:CategorieProduit")->find($request->get("Categorie")));
            $image = $produit->getImage();
            if ($image != null) {
                unlink($this->getParameter('produit_directory') . '/' . $image);
            }
            $file = $request->files->get("inputLogo");
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $produit->setImage($fileName);
            $file->move(
                $this->getParameter('produit_directory'),
                $fileName
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            //return $this->render('@CalendrierMedecins/Patient/Ajout.html.twig',array("medecin"=>$medecins));
            return $this->redirectToRoute("main_mes_produit");
        }
        return $this->render('@Front/produit/modifieRProduit.html.twig', array("categorie" => $categorie));

    }

    public function SupprimerAction($prod)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();
        $em1 = $this->getDoctrine()->getManager();
        $em1->getRepository(ProduitLike::class)->SupLikesDQL($prod);
        $produit = $em->getRepository(produit::class)->find($prod);
        $image = $produit->getImage();
        if ($image != null) {
            unlink($this->getParameter('produit_directory') . '/' . $image);
        }
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("main_mes_produit");
    }
    public function DetaillAction($prod)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();
        $em1 = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(produit::class)->find($prod);
        $pro = $em1->getRepository(ProduitLike::class)->counDQL($prod);
        $total = $em->getRepository(ProduitLike::class)->TotalDQL();
        return $this->render('@Front/produit/detailleProduit.html.twig', array("produit" => $produit, "test" => $pro[0][1], "total" => $total[0][1]));
    }

    public function acheterAction(Request $request, $prod)
    {  $date=new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(produit::class)->find($prod);
        $achat = new  AchatProduit();
        if ($request->isMethod('post')) {
            $connect = $this->getDoctrine()->getManager();
            $connect2 = $this->getDoctrine()->getManager();
            $user = $connect->getRepository(User::class)->find($this->getUser()->getId());
            $connect1 = $this->getDoctrine()->getManager();
            $user1 = $connect->getRepository(User::class)->find($prod->getUser());;
            if ($request->get('quantite') * $prod->getPrix() > $user->getSolde()) {
                return $this->render('@Front/produit/acheter.html.twig', array("produit" => $prod, "error" => "Votre solde est insuffisant"));
            } else {
                $user->setSolde($user->getSolde() - $request->get('quantite') * $prod->getPrix());
                $user1->setSolde($user1->getSolde() + $request->get('quantite') * $prod->getPrix());
                $connect->flush();
                $connect1->flush();
                $prod->setQuantite($prod->getQuantite() - $request->get('quantite'));
                $em->flush();
                $achat->setPrix($request->get('quantite') * $prod->getPrix());
                $achat->setIdProduit($prod->getId());
                $achat->setDate($date);
                $achat->setQuantite($request->get('quantite'));
                $achat->setIdAcheteur($this->getUser()->getId());
                $achat->setAcheteur($user);
                $achat->setProduit($prod->getNom());
                $achat->setImage($prod->getImage());
                $connect2->persist($achat);
                $connect2->flush();
                $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')->setUsername('fixitnow.tn@gmail.com')->setPassword('challengers123');

                $mailer = \Swift_Mailer::newInstance($transport);
                $message = \Swift_Message::newInstance()
                    ->setSubject("produit est vendu ")
                    ->setFrom(array('fixitnow.tn@gmail.com' => 'fixitnow.tn@gmail.com'))
                    ->setTo(array($user->getEmail() => $user->getEmail()))// email du client pour teste replacer par son @
                    ->setBody(
                        '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <style type="text/css">
        * {
            -webkit-font-smoothing: antialiased;
        }
        body {
            Margin: 0;
            padding: 0;
            min-width: 100%;
            font-family: Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            mso-line-height-rule: exactly;
        }
        table {
            border-spacing: 0;
            color: #333333;
            font-family: Arial, sans-serif;
        }
        img {
            border: 0;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        .webkit {
            max-width: 600px;
        }
        .outer {
            Margin: 0 auto;
            width: 100%;
            max-width: 600px;
        }
        .full-width-image img {
            width: 100%;
            max-width: 600px;
            height: auto;
        }
        .inner {
            padding: 10px;
        }
        p {
            Margin: 0;
            padding-bottom: 10px;
        }
        .h1 {
            font-size: 21px;
            font-weight: bold;
            Margin-top: 15px;
            Margin-bottom: 5px;
            font-family: Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .h2 {
            font-size: 18px;
            font-weight: bold;
            Margin-top: 10px;
            Margin-bottom: 5px;
            font-family: Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .one-column .contents {
            text-align: left;
            font-family: Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .one-column p {
            font-size: 14px;
            Margin-bottom: 10px;
            font-family: Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .two-column {
            text-align: center;
            font-size: 0;
        }
        .two-column .column {
            width: 100%;
            max-width: 300px;
            display: inline-block;
            vertical-align: top;
        }
        .contents {
            width: 100%;
        }
        .two-column .contents {
            font-size: 14px;
            text-align: left;
        }
        .two-column img {
            width: 100%;
            max-width: 280px;
            height: auto;
        }
        .two-column .text {
            padding-top: 10px;
        }
        .three-column {
            text-align: center;
            font-size: 0;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .three-column .column {
            width: 100%;
            max-width: 200px;
            display: inline-block;
            vertical-align: top;
        }
        .three-column .contents {
            font-size: 14px;
            text-align: center;
        }
        .three-column img {
            width: 100%;
            max-width: 180px;
            height: auto;
        }
        .three-column .text {
            padding-top: 10px;
        }
        .img-align-vertical img {
            display: inline-block;
            vertical-align: middle;
        }
        @media only screen and (max-device-width: 480px) {
            table[class=hide], img[class=hide], td[class=hide] {
                display: none !important;
            }
            .contents1 {
                width: 100%;
            }
            .contents1 {
                width: 100%;
            }
    </style>
</head>

<body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#f3f2f0;">
<center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#f3f2f0;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f3f2f0;" bgcolor="#f3f2f0;">
        <tr>
            <td width="100%"><div class="webkit" style="max-width:600px;Margin:0 auto;">
                    <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
                        <tr>
                            <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"><!-- ======= start header ======= -->

                                <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
                                    <tr>
                                        <td><table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                <tbody>
                                                <tr>
                                                    <td align="center"><center>
                                                            <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF"><!-- ======= start header ======= -->

                                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f3f2f0">
                                                                            <tr>
                                                                                <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:left;font-size:0;" >
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                        </table></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </center></td>
                                                </tr>
                                                </tbody>
                                            </table></td>
                                    </tr>
                                </table>

                                <!-- ======= end header ======= -->

                                <!-- ======= start hero ======= -->

                                <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0; border-left:1px solid #e8e7e5; border-right:1px solid #e8e7e5; border-bottom:1px solid #e8e7e5; border-top:1px solid #e8e7e5" bgcolor="#FFFFFF">
                                    <tr>
                                        <td background="https://gallery.mailchimp.com/fdcaf86ecc5056741eb5cbc18/images/42ba8b72-65d6-4dea-b8ab-3ecc12676337.jpg" bgcolor="#2f9780" width="100" height="100" valign="top" align="center" style="padding:50px 50px 50px 50px">


                                            <div>
                                                <br />
                                                <br />
                                                <br />
                                                <br />
                                                <p style="color:#ffffff; font-size:60px; text-align:center; font-family: Verdana, Geneva, sans-serif">FIX IT</p>

                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0; border-left:1px solid #e8e7e5; border-right:1px solid #e8e7e5; border-bottom:1px solid #e8e7e5; border-top:1px solid #e8e7e5" bgcolor="#FFFFFF">
                                    <tr>
                                        <td align="center" style="padding:50px 50px 50px 50px"><p style="color:#262626; font-size:24px; text-align:center; font-family: Verdana, Geneva, sans-serif"><strong>le produit  '.$prod->getNom().' de quantite'.$request->get('quantite').'</strong></p>
                                            <p style="color:#262626; font-size:16px; text-align:center; font-family: Verdana, Geneva, sans-serif; line-height:22px ">l adress client:  '.$user1->getAddress().' vous envoyez avant 24h<br />
                                            <p> vous pouvez paratge votre site pour plus des ventes</p>
                                            <br />
                                            <br />
                                            </p>

                                    </tr>
                                    </tbody>
                                </table>
                                <p style="color:#000000; font-size:12px; text-align:center; font-family: Verdana, Geneva, sans-serif; line-height:22px "> <br />
                                    <br />
                                    Lorem Ipsum loren ipsum</p></td>
                        </tr>
                    </table>

            </td>
        </tr>
    </table>
    </div></td>
    </tr>
    </table>
</center>
</body>
</html>',
                        'text/html'
                    );
                $result = $mailer->send($message);
                return $this->render('@Front/produit/acheter.html.twig', array("produit" => $prod, "message" => "L'achat a été effectué"));
            }

        }
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        return $this->render('@Front/produit/acheter.html.twig', array("produit" => $prod));
    }

    public function MesProduitsAction(Request $r)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Produit::class)->mesProduitsDQL($id);

                return $this->render('@Front/produit/mesProduit.html.twig', array("produit" => $prod));
    }

    public function EchangeAction()
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $user = $this->getUser();
        $id = $user->getId();
        $solde = $user->getSolde();
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(user::class)->find($id);
        $prod = setSold($prod->getSolde());
        var_dump($solde);
        return $this->render('@Front/produit/mesProduit.html.twig', array("produit" => $prod));
    }

    public function afficherTriFrontAction(Request $request)
    {

        $em1 = $this->getDoctrine()->getManager();
        $produit = $em1->getRepository(Produit::class)->findAll();
        if (isset($_GET['tri']) or isset($_GET['triDSC'])) {

            if (($request->get("tri") == "nom?triDSC=asc")) {
                $produit1 = $em1->getRepository(Produit::class)->triNomASC();
                return $this->render("@Front/produit/tri..html.twig", array("produit" => $produit1, "tri" => "nom", "triDSC" => "asc"));
                var_dump($produit1);

            } elseif (($request->get("tri") == "prix?triDSC=asc")) {
                $produit2 = $em1->getRepository(Produit::class)->triPrixASC();
                return $this->render("@Front/produit/tri..html.twig", array("produit" => $produit2, "tri" => "prix", "triDSC" => "asc"));
            } elseif (($request->get("tri") == "nom?triDSC=dsc")) {
                $produit1 = $em1->getRepository(Produit::class)->triNomDSC();
                return $this->render("@Front/produit/tri..html.twig", array("produit" => $produit1, "tri" => "nom", "triDSC" => "dsc"));
            } elseif (($request->get("tri") == "prix?triDSC=dsc")) {
                $produit1 = $em1->getRepository(Produit::class)->triPrixDSC();
                return $this->render("@Front/produit/tri..html.twig", array("produit" => $produit1, "tri" => "prix", "triDSC" => "dsc"));
            }


        }

        return $this->render("@Front/produit/tri..html.twig", array("produit" => $produit, "tri" => "", "triDSC" => ""));


    }

    public function meilleurProduitAction()
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(AchatProduit::class)->TopDQL();
        var_dump($prod);
        return $this->render('@Front/produit/produitTop.html.twig',array("pro"=>$prod));

    }
    public function ListeCategorieAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository(CategorieProduit::class)->findAll();
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository(Produit::class)->findAll();
        return $this->render('@Front/produit/listCategorieFront.html.twig',array("categorie"=>$categorie,"produit"=>$produit));

    }
}
