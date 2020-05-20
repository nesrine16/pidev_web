<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Commande;
use UserBundle\Entity\LigneCommande;

class PanierController extends AbstractController
{
    public function panierAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->findOneBy(array('user'=>$this->getUser(), 'etat'=> 'en cours'));

        return $this->render('@User/panier/panier.html.twig', array(
            'commande'=> $commande
        ));
    }

    public function miseAjourPanierAction(Request $request, Commande $commande)
    {

        if($commande->getUser() == $this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $lignes = $commande->getLignes();
            foreach ($lignes as $ligne){
                $ligne->setQte($request->request->get($ligne->getId()));
                $em->flush();
                $commande->setMontant($commande->calculMontant());
                $em->flush();
            }
        }

        return $this->redirectToRoute('voir_panier');
    }

    public function supprimerLigneAction(LigneCommande $ligneCommande)
    {
        $commande = $ligneCommande->getCommande();
        if($ligneCommande->getCommande()->getUser() == $this->getUser()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($ligneCommande);
            $em->flush();
            $commande->setMontant($commande->calculMontant());
            $em->flush();
        }

        return $this->redirectToRoute('voir_panier');
    }

    public function validerAction(Commande $commande)
    {
        if($commande->getUser() == $this->getUser()) {
            $commande->setDateCommande(new \DateTime());
            $commande->setEtat('en attente');
            $em = $this->getDoctrine()->getManager();
            $em->flush();

        }

        return $this->redirectToRoute('voir_commande_apres_validation', array('id'=> $commande->getIdCommande()));
    }

    // le client sera redirigé vesr cette action apres qu'il valide la commande
    // cette action va afficher la commande envoyé
    public function voirCommandeAction(Commande $commande)
    {
        if($commande->getUser() != $this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('@User/panier/commande.html.twig', array(
            'commande'=> $commande
        ));
    }
}