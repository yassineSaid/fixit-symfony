<?php

namespace BackBundle\Controller;

use MainBundle\Entity\RealisationService;
use MainBundle\Entity\Reclamation;
use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Snappy\Pdf;

class ReclamationBackController extends Controller
{

    public function ListeReclamationAdminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->findAll();
        return $this->render('@Back/Reclamations/ListReclamationAdmin.html.twig',array("recs"=>$reclamation));

    }

    public  function detaillerecadminAction($rec)
    {
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find($rec);
        $rec->setSeen(1);
        $em->flush();
        return $this->render('@Back/Reclamations/detaillerec.html.twig',array("rec"=>$rec));
    }

    public function traiteadminAction($rec)
    {
        $em=$this->getDoctrine()->getManager();
        $rec=$em->getRepository(Reclamation::class)->find($rec);
        $rec->setTraite(1);
        $userrec=$rec->getUserreclame();
        $user=$rec->getUser();
        $em->flush();
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')->setUsername('fixitnow.tn@gmail.com')->setPassword('challengers123');

        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance()
            ->setSubject("Votre réclamation est traité")
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
                    <td align="center" style="padding:50px 50px 50px 50px"><p style="color:#262626; font-size:24px; text-align:center; font-family: Verdana, Geneva, sans-serif"><strong>Mr '.$user->getFirstname().'</strong></p>
                      <p style="color:#262626; font-size:16px; text-align:center; font-family: Verdana, Geneva, sans-serif; line-height:22px ">votre reclamation qui a comme objet  '.$rec->getObject().' a été bien traité de la part de nos adminiistrateurs<br />
                      <p> votre réclamation a été bien traité par les administrateur</p>
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



        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance()
            ->setSubject("Reclamation contre vous")
            ->setFrom(array('fixitnow.tn@gmail.com' => 'fixitnow.tn@gmail.com'))
            ->setTo(array($userrec->getEmail() => $userrec->getEmail()))// email du client pour teste replacer par son @
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
                    <td align="center" style="padding:50px 50px 50px 50px"><p style="color:#262626; font-size:24px; text-align:center; font-family: Verdana, Geneva, sans-serif"><strong>Mr '.$userrec->getFirstname().'</strong></p>
                      <p style="color:#262626; font-size:16px; text-align:center; font-family: Verdana, Geneva, sans-serif; line-height:22px ">Une réclamation a été faite contre vous de la part de '.$user-> getFirstname().'<br />
                        <strong>PS : 3 Reclamation et votre compte sera banné</strong>
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
        $file=new Pdf("\"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe\"");
        $date=new \DateTime();
        $file->generateFromHtml('<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div align="left">
		<img src="logo.png" width="100px" height="150px">
		<h3>Administration de fixit</h3>
	</div>
	<div align="right" style="font-size: 22px">
		<p>Le '.$date->format("Y-m-d").' </p>
	</div>
	<div align="center">
	<fieldset>
		<legend>Rapport de Reclamation</legend>
		<div align="left" style="font-style: Times New Roman Georgia">
			<p>Mr'.$user->getFirstname().'</p>
			<br>
			<br>
			<p> Je suis '.$this->getUser()->getFirstname().' de l\'administration de fixit.</p>
			<p> Votre Réclamation d\'identifiant '.($rec->getId()*45896).' a été prise en considération.</p>
			<u><p>Reclamation :</p></u>
			<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Objet : '.$rec->getObject().'</p>
			<p>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Description :'.$rec->getDescription().'</p>
			<p>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La personne que vous avez réclamer :'.$userrec->getFirstname().' </p>

			<p>
			 Nous sommes désolés de cet incident et nous vous prions de bien vouloir nous en excuser. 
			 Nous tenons à vous remercier de votre confiance et à vous assurer que nous prenons des mesures auprès de la personne sue vous avez réclamé pour nous assurer que ce problème ne se reproduise plus.
			 Nous vous prions de croire, Madame, Monsieur, à l’assurance de nos sentiments les meilleurs.
			</p>
		</div>

	</fieldset>
	</div>
	
</body>
</html>',$this->getParameter('pdf_directory').'r'.$rec->getId().'.pdf',array(
            'encoding' => 'utf-8',
        ));

        return $this->redirectToRoute('main_liste_reclamation_admin');
    }

    public function supprimeradminAction($rec)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($rec);
        $reclamation->setShow(1);
        var_dump($reclamation);
        $em->flush();
        return $this->redirectToRoute('main_liste_reclamation_admin');
    }

    public function afficherReclamationTraiteAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->findReclamationTraite();
        return $this->render('@Back/Reclamations/listreclamationnontraite.html.twig',array("recs"=>$reclamation));
    }

    public function afficherReclamationArchiveAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->findReclamationArchive();
        return $this->render('@Back/Reclamations/archivereclamation.html.twig',array("recs"=>$reclamation));
    }



}
