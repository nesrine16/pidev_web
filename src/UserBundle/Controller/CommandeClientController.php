<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Article;
use UserBundle\Entity\Commande;
use UserBundle\Entity\LigneCommande;

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
}