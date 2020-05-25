<?php

namespace CommandeBundle\Controller;

use CommandeBundle\Entity\Article;
use CommandeBundle\Entity\Commande;
use CommandeBundle\Entity\Lignecommande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\Fournisseur;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use JMS\Serializer\SerializerBuilder;
class commandeController extends AbstractController
{


    public function newCommandeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->findBy(array( 'etat'=>'en cours'));

        return $this->render('@Commande/Article/newCommande.html.twig',
            ['commandes'=> $commande]
        );


    }

    public function addArticleAction(Request $request)
    {

        $refArticle = $request->request->get('refArticle');
        $qte = $request->request->get('qte');


        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($refArticle);

        $commandeEnCours = $em->getRepository(Commande::class)->findOneBy(array('etat' => 'en cours'));
        if ($commandeEnCours == false) {
            $commande = new Commande();
            // $commande->setIdCommande($last);

            $commande->setEtat('en cours');
            $commande->setType('entrée');
            $em->persist($commande);

            $ligneCommande = new Lignecommande();
            $ligneCommande->setRefArticle($article);
            $ligneCommande->setIdCommande($commande);
            $ligneCommande->setQte(intval($qte));
            //dump($ligneCommande);die;
            $em->persist($ligneCommande);

            $em->flush();
        }
        else {
            $ligneCommandeExite = $em->getRepository(Lignecommande::class)->findOneBy(array('idCommande' => $commandeEnCours, 'refArticle' => $article));
            if ($ligneCommandeExite) {
                $ligneCommandeExite->setQte($qte);

            } else {
                $ligneCommande = new LigneCommande();
                $ligneCommande->setrefArticle($article);
                $ligneCommande->setIdCommande($commandeEnCours);
                $ligneCommande->setQte($qte);
                $em->persist($ligneCommande);
            }
            $em->flush();
        }
       return $this->redirectToRoute('show_article');


    }


    public function supprimerLigneAction(Request $request)
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $LigneCommande=$em->getRepository(Lignecommande::class)->find($id);
        $em->remove($LigneCommande);
        $em->flush();
            $em->flush();


        return $this->redirectToRoute('new_commande');
    }

    public function updateLigneAction(Request $request, Commande $commande)
    {
            $em = $this->getDoctrine()->getManager();
            $lignes = $commande->getLignes();
            foreach ($lignes as $ligne){
                $ligne->setQte($request->request->get($ligne->getId()));
                $em->flush();
            }


        return $this->redirectToRoute('new_commande');
    }

    public function AjouterAction(Commande $commande, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if($commande->getEtat() == "en cours") {
           // $total = $request->request->get($commande->getMontant());


            $commande->setMontant($request->request->get("montant"));
            $commande->setNumCommande($request->request->get("numCommande"));

            $commande->setDateLivraison(new \DateTime($request->request->get("dateLivraison")) );
            $commande->setDateCommande(new \DateTime($request->request->get("dateCommande")));



             $commande->setEtat('en attente');
            $em->flush();


        }


        return $this->redirectToRoute('show_article');
    }





    public function listArticleAction (Request $request,$ref)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($ref);


        $commandeEnCours = $em->getRepository(Commande::class)->findOneBy(array('etat' => 'en cours'));
        if ($commandeEnCours == false) {
            $commande = new Commande();


            $commande->setEtat('en cours');
            $commande->setType('entrée');
            $em->persist($commande);

            $ligneCommande = new Lignecommande();
            $ligneCommande->setRefArticle($article);
            $ligneCommande->setIdCommande($commande);
            $ligneCommande->setQte($request->get('qte'));
            //dump($ligneCommande);die;
            $em->persist($ligneCommande);

            $em->flush();


        }
        else {
            $ligneCommandeExite = $em->getRepository(Lignecommande::class)->findOneBy(array('idCommande' => $commandeEnCours, 'refArticle' => $ref));
            if ($ligneCommandeExite) {
                $ligneCommandeExite->setQte($request->get('qte'));


            }
            else {
                $ligneCommande = new LigneCommande();
                $ligneCommande->setrefArticle($article);
                $ligneCommande->setIdCommande($commandeEnCours);
                $ligneCommande->setQte($request->get('qte'));
                $em->persist($ligneCommande);


            }
                $em->flush();
        }

        return  new JsonResponse("success");
    }

    public function getCommandeAction()
    {
        $em= $this->getDoctrine()->getManager();
        $etat= "en cours";
        // $palettes= $this->getDoctrine()->getManager()->getRepository('PaletteBundle:Palette')->findAll();
        $dql="  SELECT IDENTITY(L.refArticle), L.qte, A.codeBarres, A.designation from CommandeBundle:Lignecommande L, CommandeBundle:Article A,
         CommandeBundle:Commande C WHERE L.refArticle=A.refArticle  and C.idCommande=L.idCommande and C.etat='en cours'";
        $query= $em->createQuery($dql);
        $res= $query->getResult();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);

    }

    public function AjouterCommandeAction($num, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commande =$em->getRepository('CommandeBundle:Commande')->find($num);


            // $total = $request->request->get($commande->getMontant());


            $commande->setMontant($request->get("montant"));
            $commande->setNumCommande($request->get("numCommande"));

            $commande->setDateLivraison(new \DateTime($request->get("dateLivraison")) );
            $commande->setDateCommande(new \DateTime($request->get("dateCommande")));

            $commande->setEtat('en attente');


            $em->flush();


           $serializer=new Serializer([new ObjectNormalizer()]);
           $formatted = $serializer->normalize( $commande);
          return new JsonResponse($formatted);


    }


    public function lastCmdAction()
    {

        $em= $this->getDoctrine()->getManager();
        $dql=" SELECT p.idCommande FROM CommandeBundle:Commande p where p.etat='en cours' ";

        $query= $em->createQuery($dql);

        //dump($query->getResult());die();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($query->getResult());
        return new JsonResponse($formatted);

    }

    public function updateqteAction(Request $request,$ref)
    {        $em = $this->getDoctrine()->getManager();

        $commandeEnCours = $em->getRepository(Commande::class)->findOneBy(array('etat' => 'en cours'));
        $ligneCommandeExite = $em->getRepository(Lignecommande::class)->findOneBy(array('idCommande' => $commandeEnCours, 'refArticle' => $ref));
        if ($ligneCommandeExite) {
            $ligneCommandeExite->setQte($request->get('qte'));

        }
        $em->flush();


        return  new JsonResponse("success");

    }

    public function deleteLigneAction(Request $request,$ref)
    { $em = $this->getDoctrine()->getManager();

        $commandeEnCours = $em->getRepository(Commande::class)->findOneBy(array('etat' => 'en cours'));
        $ligneCommandeExite = $em->getRepository(Lignecommande::class)->findOneBy(array('idCommande' => $commandeEnCours, 'refArticle' => $ref));
        if ($ligneCommandeExite) {
            $em->remove($ligneCommandeExite);
            $em->flush();

        }

        return new JsonResponse("success");

    }




    public function getAllCommandeAction()
    {
        $em= $this->getDoctrine()->getManager();
        $dql="SELECT C.numCommande, A.refArticle, L.qte, F.nomsociete, C.montant, C.etat FROM CommandeBundle:Lignecommande L,CommandeBundle:Commande C, CommandeBundle:Article A, CommandeBundle:Fournisseur F
                WHERE L.idCommande = C.idCommande and 
               L.refArticle=A.refArticle AND A.fournisseur=F.id ORDER BY C.numCommande DESC ";
        $query= $em->createQuery($dql);
        $res= $query->getResult();
        //dump($res); die();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);

    }


        public function getCmdAction()
    {        $em= $this->getDoctrine()->getManager();

        $all = $this->getDoctrine()->getManager()>getRepository(Commande::Class)->findAll();;
        $dql= "select c from CommandeBundle:Commande c";
        $query= $em->createQuery($dql);
        $res= $query->getResult();

       // $ser = new Serializer([new ObjectNormalizer()]);
       // $formated = $ser->normalize($res);
       // return new JsonResponse($formated);

        $serializer = SerializerBuilder::create()->build();
        $jsonObject = $serializer->serialize($all, 'json');

        return $jsonObject;




    }


    }