<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//ya5i ne7itou akel constructeur elli fi ArrayCollection ??
/**
 * Lignecommande
 *
 * @ORM\Table(name="LigneCommande", indexes={@ORM\Index(name="ref_article", columns={"ref_article"}), @ORM\Index(name="id_commande", columns={"id_commande"})})
 * @ORM\Entity
 */
class Lignecommande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="qte", type="integer")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="ref_article",referencedColumnName="ref_article")
     */
    private $refArticle;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Commande", inversedBy="lignes",fetch="EAGER")
     * @ORM\JoinColumn(name="id_commande", referencedColumnName="id_commande")
     */

    private $idCommande;

    /**
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * @param int $qte
     */
    public function setQte($qte)
    {
        $this->qte = $qte;
    }

    /**
     * @return \Article
     */
    public function getRefArticle()
    {
        return $this->refArticle;
    }

    /**
     * @param \Article $refArticle
     */
    public function setRefArticle($refArticle)
    {
        $this->refArticle = $refArticle;
    }


    /**
     * Get IdCommande
     *
     * @return \CommandeBundle\Entity\Commande
     */
    public function getIdCommande()
    {
        //return $this->IdCommande;
return $this->idCommande;
    }


    /**
     * Set IdCommande
     *
     * @param \CommandeBundle\Entity\Commande $IdCommande
     *
     * @return Lignecommande
     */
    public function setIdCommande(\CommandeBundle\Entity\Commande $IdCommande = null)
    {
        //$this->IdCommande = $IdCommande;this
$this->idCommande = $IdCommande;
        return $this;
    }

}

