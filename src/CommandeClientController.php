<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use CommandeBundle\Entity\Article;
use UserBundle\Entity\Commande;
use UserBundle\Entity\LigneCommande;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\User;
use UserBundle\Repository\CommandeRepository;



class CommandeClientController extends AbstractController
{
    public function ajouterAuPanierAction(Request $request)
    {

        $refArticle = $request->request->get('refArticle');
        $qte = $request->request->get('qte');

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($refArticle);

        $commandeEnCours = $em->getRepository(Commande::class)->findOneBy(array('user'=> $this->getUser(),'etat' => 'en cours'));

        if ($commandeEnCours == false) {
            $commande = new Commande();
            $commande->setUser($this->getUser());
            $commande->setEtat('en cours');
            $commande->setType('sortie');
            $commande->setMontant(0);
            $em->persist($commande);

            $ligneCommande = new LigneCommande();
            $ligneCommande->setArticle($article);
            $ligneCommande->setCommande($commande);
            $ligneCommande->setQte($qte);
            $em->persist($ligneCommande);

            $em->flush();// executer les requetes sql sur la base
            $commande->setMontant($commande->calculMontant());
            $em->flush();

        } else {
            $ligneCommandeExite = $em->getRepository(LigneCommande::class)->findOneBy(array('Commande' => $commandeEnCours, 'Article' => $article));
            if ($ligneCommandeExite) {
                $ligneCommandeExite->setQte($qte);

            } else {
                $ligneCommande = new LigneCommande();
                $ligneCommande->setArticle($article);
                $ligneCommande->setCommande($commandeEnCours);
                $ligneCommande->setQte($qte);
                $em->persist($ligneCommande);
            }
            $em->flush();
            $commandeEnCours->setMontant($commandeEnCours->calculMontant());
            $em->flush();
        }

        return $this->redirectToRoute('article_listmy');

    }


    /**
     * fonction ajoutcommande mobile
     */


    public function ajoutCommandeClientAction(Request $request ,$ref)
    {
       // die($request->get("ref"));
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find(array("refArticle"=>$request->get("ref")));

       $commandeEnCours = $em->getRepository(Commande::class)->findOneBy(array('user'=> $this->getUser(),'etat' => 'en cours'));
        if ($commandeEnCours == false) {
            $commande = new Commande();

            $commande->setUser($this->getUser(3));

            $commande->setEtat('en cours');
            $commande->setType('sortie');
            $em->persist($commande);

            $ligneCommande = new Lignecommande();
            $ligneCommande->setArticle($article);
            $ligneCommande->setCommande($commande);
            $ligneCommande->setQte($request->get('qte'));
            //dump($ligneCommande);die;
            $em->persist($ligneCommande);

            $em->flush();


        }
        else {
            $ligneCommandeExite = $em->getRepository(Lignecommande::class)->findOneBy(array('Commande' => $commandeEnCours, 'Article' =>$article));
            if ($ligneCommandeExite) {
                $ligneCommandeExite->setQte($request->get('qte'));


            }
            else {
                $ligneCommande = new LigneCommande();
                $ligneCommande->setArticle($article);
                $ligneCommande->setCommande($commandeEnCours);
                $ligneCommande->setQte($request->get('qte'));   $em->persist($ligneCommande);


            }
            $em->flush();
        }
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername('nesrine.benabdelkarim@esprit.tn')
            ->setPassword('Nesrine123456');




        $em = $this->getDoctrine()->getManager();
        $headers = "\r\n" . "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers .= "Message-ID: <" . time() . " TheSystem@" . $_SERVER['SERVER_NAME'] . ">\r\n";
        $headers .= "X-Mailer: PHP v" . phpversion() . "\r\n";
        $mailer = new \Swift_Mailer($transport);
        $message = \Swift_Message::newInstance()
            ->setSubject('Commande Validée')
            ->setFrom('nesrine.benabdelkarim@esprit.tn')
            ->setTo('nesrine.benabdelkarim@esprit.tn')
            ->setBody(' Cher(e) '. 'nejib' .' Nous vous informons que votre commande N° ' .'28' . ' a été prise en compte, vous avez au maximum 5 heures pour modifier votre commande - merci pour votre achat
            Cordialement l\Smart Truck ');

        $mailer->send($message);

        return  new JsonResponse("success");








        /* $commande = new Commande();
        //$ligneCommande = new LigneCommande();
        $refArticle = $request->query->get('refArticle');
        $qte = $request->query->get('qte');
        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($refArticle);

        $user = $em->getRepository(User::class)->findOneBy(["id"=>$id]);

        $commande->setUser($user);

            $commande->setEtat('en cours');
            $commande->setType('sortie');
        $commande->setMontant($commande->calculMontant());

        $em->persist($commande);

            $ligneCommande = new LigneCommande();
            $ligneCommande->setArticle($article);
            $ligneCommande->setCommande($commande);
            $ligneCommande->setQte($qte);

            $em->persist($ligneCommande);

            $em->flush();// executer les requetes sql sur la base
           // $ser= new Serializer([new ObjectNormalizer()]);
           // $formated = $ser->normalize($commande);
          //  $formated = $ser->normalize($ligneCommande);
           // return new JsonResponse($formated) ;



        $ser= new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($commande);
        return new JsonResponse($formated) ;

        */

    }



    public function updateqteAction(Request $request,$ref)
    {       $em = $this->getDoctrine()->getManager();

        $commandeEnCours = $em->getRepository(Commande::class)->findOneBy(array('etat' => 'en cours'));
        $ligneCommandeExite = $em->getRepository(Lignecommande::class)->findOneBy(array('Commande' => $commandeEnCours, 'Article' => $ref));
        if ($ligneCommandeExite) {
            $ligneCommandeExite->setQte($request->get('qte'));
           $em->persist($ligneCommandeExite);
            $em->flush();

        }

        return new JsonResponse("success");

    }





    public function lastCmdAction()
    {
        $em= $this->getDoctrine()->getManager();
        $etat= "en cours";
        $dql="  SELECT  L.qte, A.refArticle,A.prixVente,C.etat, A.designation from UserBundle:LigneCommande L, CommandeBundle:Article A,
         UserBundle:Commande C WHERE L.Article = A.refArticle and C.id_commande=L.Commande and C.etat='en cours'";
        $query= $em->createQuery($dql);
        $res= $query->getResult();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);



    }
    public function deleteLigneclientAction(Request $request,$ref)
    { $em = $this->getDoctrine()->getManager();

        $commandeEnCours = $em->getRepository(Commande::class)->findOneBy(array('etat' => 'en cours'));
        $ligneCommandeExite = $em->getRepository(Lignecommande::class)->findOneBy(array('Commande' => $commandeEnCours, 'Article' => $ref));
        if ($ligneCommandeExite) {
            $em->remove($ligneCommandeExite);
            $em->flush();

        }

        return new JsonResponse("success");

    }


    public function deletecommandeclientAction(Request $request)
    {$em=$this->getDoctrine()->getManager();

        $commande= $em->getRepository('UserBundle:Commande')->find($request->get('id'));
        $em->remove($commande);
        $em->flush();


        return new JsonResponse("success");

    }








    public function getuserAction(Request $request )
    {
        $username = $request->query->get('username');
        $password = $request->query->get('password');
        $data = [];
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["username" => $username]);
        if ($user != null) {
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            $valide = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
            if ($valide)
                array_push($data, $user);
        }
        $ser= new Serializer([new ObjectNormalizer()]);
        $formated = $ser->normalize($data);
        return new JsonResponse($formated) ;

    }










    public function getAllCommandeclientsAction()
    {
        $em= $this->getDoctrine()->getManager();
        $em->getRepository(Commande::class)->findOneBy(array('user'=> $this->getUser(),'etat' => 'en cours'));
        $dql="SELECT  C.id_commande, A.refArticle, L.qte,A.seuilMin,A.seuilMax,F.nom,C.date_livraison, C.etat FROM UserBundle:LigneCommande L,UserBundle:Commande C, CommandeBundle:Article A,UserBundle:User F
        WHERE L.Article=A.refArticle  and C.id_commande=L.Commande  and C.etat='en cours' and F.nom='nejib' ";
        $query= $em->createQuery($dql);
        $res= $query->getResult();
        //dump($res); die();


        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);

    }
    public function updateCommandeclientAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $cmd= $em->getRepository('UserBundle:Commande')->find($request->get("id"));


       $cmd->setNumCommande($request->get('num'));
        $cmd->setEtat($request->get('etat'));

        $cmd->setDateLivraison(new \DateTime($request->get('date')));


        $em->persist($cmd);
        $em->flush();

        return new JsonResponse("success" );

    }

    public function mailMobileAction (Request $request, $corps, $obj, $to){
        $em = $this->getDoctrine()->getManager();
        $message = \Swift_Message::newInstance()
            ->setSubject($obj)
            ->setFrom('nesrine.benabdelkarim@esprit.tn','Smart Truck Application')
            ->setTo($to)
            ->setBody($corps);
        $this->get('mailer')->send($message);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize($message);

        return new JsonResponse("success");
    }

    public function findCommandeAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        //  $serializer = SerializerBuilder::create()->build();

        $cmd = $em->getRepository(Commande::class)->find($request->get('id'));
        /*  $normalizer = new ObjectNormalizer();
          $normalizer->setCircularReferenceLimit(2);
          $normalizer->setCircularReferenceHandler(function ($cmd) {
              return $cmd->getIdCommande();
          });
        */
        // $normalizers = array($normalizer);
        // $serializer = new Serializer($normalizers);

        // $serializer =  $this->get('jms_serializer');
        //$jsonObject = $serializer->serialize( $cmd, 'json');

        return new JsonResponse("success" );


        // return $serializer->serialize($cmd, 'json', SerializationContext::create()->setGroups(array('article')));


    }
    public function SearchByNomFamilleAction(\Symfony\Component\HttpFoundation\Request $request,$nomFamille)
    {
        $em=$this->getDoctrine()->getManager();
        $commande= $em->getRepository('CommandeBundle:Article')->findOneBy(array('designation' => 'boissons'));

        $em->flush();
        //dump($res); die();


        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commande);
        return new JsonResponse($formatted);
    }



    }

