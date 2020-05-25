<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="Article", indexes={@ORM\Index(name="id_utilisateur", columns={"id_utilisateur"}), @ORM\Index(name="famille", columns={"famille"}), @ORM\Index(name="fournisseur", columns={"fournisseur"})})
 * @ORM\Entity
 */
class Article
{
    /**
     * @var string
     *
     * @ORM\Column(name="ref_article", type="string", length=200, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="code_barres", type="string", length=200, nullable=false)
     */
    private $codeBarres;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=200, nullable=false)
     */
    private $designation;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_vente", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixVente;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_achat", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixAchat;

    /**
     * @var string
     *
     * @ORM\Column(name="unite", type="string", length=191, nullable=false)
     */
    private $unite;

    /**
     * @var integer
     *
     * @ORM\Column(name="seuil_min", type="integer", nullable=false)
     */
    private $seuilMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="seuil_max", type="integer", nullable=false)
     */
    private $seuilMax;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=true)
     */
    private $idUtilisateur;

    /**
     * @var \Famille
     *
     * @ORM\ManyToOne(targetEntity="Famille")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="famille", referencedColumnName="codeFamille")
     * })
     */
    private $famille;

    /**
     * @var \Fournisseur
     *
     * @ORM\ManyToOne(targetEntity="Fournisseur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fournisseur", referencedColumnName="id")
     * })
     */
    private $fournisseur;



    /**
     * @return string
     */
    public function getRefArticle()
    {
        return $this->refArticle;
    }

    /**
     * @param string $refArticle
     */
    public function setRefArticle($refArticle)
    {
        $this->refArticle = $refArticle;
    }

    /**
     * @return string
     */
    public function getCodeBarres()
    {
        return $this->codeBarres;
    }

    /**
     * @param string $codeBarres
     */
    public function setCodeBarres($codeBarres)
    {
        $this->codeBarres = $codeBarres;
    }

    /**
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    /**
     * @return float
     */
    public function getPrixVente()
    {
        return $this->prixVente;
    }

    /**
     * @param float $prixVente
     */
    public function setPrixVente($prixVente)
    {
        $this->prixVente = $prixVente;
    }

    /**
     * @return float
     */
    public function getPrixAchat()
    {
        return $this->prixAchat;
    }

    /**
     * @param float $prixAchat
     */
    public function setPrixAchat($prixAchat)
    {
        $this->prixAchat = $prixAchat;
    }

    /**
     * @return string
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * @param string $unite
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;
    }

    /**
     * @return int
     */
    public function getSeuilMin()
    {
        return $this->seuilMin;
    }

    /**
     * @param int $seuilMin
     */
    public function setSeuilMin($seuilMin)
    {
        $this->seuilMin = $seuilMin;
    }

    /**
     * @return int
     */
    public function getSeuilMax()
    {
        return $this->seuilMax;
    }

    /**
     * @param int $seuilMax
     */
    public function setSeuilMax($seuilMax)
    {
        $this->seuilMax = $seuilMax;
    }

    /**
     * @return int
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * @param int $idUtilisateur
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;
    }

    /**
     * @return \Famille
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * @param \Famille $famille
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;
    }

    /**
     * @return \Fournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * @param \Fournisseur $fournisseur
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;
    }

    public function __toString()
    {

        if(is_null($this->refArticle)) {
            return 'NULL';
        }

      return $this->refArticle;
    }


}

