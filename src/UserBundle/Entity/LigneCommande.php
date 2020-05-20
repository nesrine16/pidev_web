<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCommande
 *
 * @ORM\Table(name="ligne_commande")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\LigneCommandeRepository")
 */
class LigneCommande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Commande", inversedBy="lignes")
     * @ORM\JoinColumn(name="id_commande",referencedColumnName="id_commande")
     */
    private $Commande;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Article")
     * @ORM\JoinColumn(name="ref_article",referencedColumnName="ref_article")
     */
    private $Article;

    public function totalLigne()
    {
        return $this->qte * $this->getArticle()->getPrixVente();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set qte
     *
     * @param integer $qte
     *
     * @return LigneCommande
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return integer
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set commande
     *
     * @param \UserBundle\Entity\Commande $commande
     *
     * @return LigneCommande
     */
    public function setCommande(\UserBundle\Entity\Commande $commande = null)
    {
        $this->Commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \UserBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->Commande;
    }

    /**
     * Set article
     *
     * @param \UserBundle\Entity\Article $article
     *
     * @return LigneCommande
     */
    public function setArticle(\UserBundle\Entity\Article $article = null)
    {
        $this->Article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \UserBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->Article;
    }
}
