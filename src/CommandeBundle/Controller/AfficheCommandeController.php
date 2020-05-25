<?php
namespace CommandeBundle\Controller;
use CommandeBundle\Entity\Article;
use CommandeBundle\Entity\Commande;
use CommandeBundle\Entity\Lignecommande;
use PaletteBundle\Entity\Palette;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use CommandeBundle\Repository\CommandeRepository;


class AfficheCommandeController extends AbstractController
{

    public function showCommandeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
       // $commande = $em->getRepository(Commande::class)->findAll();

        $dql=" SELECT p FROM CommandeBundle:Commande p";
        $query= $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)

        );

        //$dql =" SELECT Commande.num_commande,Lignecommande.ref_article,qte,Fournisseur.nomSociete,date_commande,montant,commande.date_livraison,commande.etat "
        //+ "FROM CommandeBundle:Lignecommande,CommandeBundle:Commande,CommandeBundle:Article,CommandeBundle:Fournisseur"
        //+ " WHERE Lignecommande.id_commande = Commande.id_commande and "
        //+ "Lignecommande.ref_article=Article.ref_article AND Article.fournisseur=Fournisseur.id ORDER BY Commande.num_commande DESC; ";
       // $query= $em->createQueryBuilder($dql);
        //$bugs = $query->getFirstResult();
        //$commande= $query->getResult();

        return $this->render('@Commande/Article/showCommande.html.twig',
            ['commandes'=> $pagination]);
    }



    public function editCommandeAction(Request $request){

        $numCommande = $request->request->get('numCommande');
        //$refArticle = $request->request->get('refArticle');



        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->findBy(array( 'numCommande'=>$numCommande));

        return $this->render('@Commande/Article/editCommande.html.twig',
            ['commandes'=> $commande]
        );



    }

    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $motcle=$request->get('motcle');
        $repository=$em->getRepository('CommandeBundle:Commande');

        $list=$repository->createQueryBuilder('f')
            ->where('f.numCommande like :numCommande')
            ->setParameter('numCommande', $motcle.'%')
            ->orderBy('f.numCommande','ASC')
            ->getQuery()
            ->getResult();


        $pagination = $this->get('knp_paginator')->paginate(
            $list, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)

        );
        return $this->render('@Commande/Article/showCommande.html.twig',
            ['commandes'=> $pagination]);

    }


    public function mailAction(Request $request){
        $id=$request->get('id');
        //dump($id);die();
        $em = $this->getDoctrine()->getManager();
        $fournisseur = $em->getRepository('UserBundle:Fournisseur')->find($id);
        //dump($fournisseur);die();


//        if($request->isMethod('POST')){
        $message = \Swift_Message::newInstance()
            ->setSubject($request->get('objet'))
            ->setFrom('imen.elabed@esprit.tn','smart truck')
            ->setTo('imen.elabed@esprit.tn')
            ->setBody($request->get('message'));


        $this->get('mailer')->send($message);

//        }


        return $this->render('@Commande/Article/mail.html.twig',array(
            'fournisseur'=>$fournisseur
        ));

    }
    public function deleteCommandeAction(Request $request){

        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $commande=$em->getRepository(Commande::class)->find($id);
        $commande->setEtat('confirmée');
        $em->persist($commande);

        $dql=" SELECT p FROM CommandeBundle:Commande p";
        $query= $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)

        );


        return $this->render('@Commande/Article/showCommande.html.twig',
            ['commandes'=> $pagination]
        );



    }



}





