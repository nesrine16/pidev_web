<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 * @ORM\Entity(repositoryClass="UserBundle\Repository\ArticleRepository")
 * @ORM\Table(name="article")
 */
class Article
{
    /**
     * @var string
     *
     * @ORM\Column(name="ref_article", type="string")
     * @ORM\Id
     */
    private $refArticle;


    /**
     * @var string
     *
     * @ORM\Column(name="code_barres", type="string")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=255)
     */
    private $designation;


    /**
     * @var float
     *
     * @ORM\Column(name="prix_achat", type="float")
     */
    private $prixAchat;


    /**
     * @var int
     *
     * @ORM\Column(name="seuil_max", type="integer")
     */
    private $seuilMax;

    /**
     * @var int
     *
     * @ORM\Column(name="seuil_min", type="integer")
     */
    private $seuilMin;

    /**
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string")
     */
    private $img;


    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Famille")
     * @ORM\JoinColumn(name="famille",referencedColumnName="codeFamille")
     */
    private $Famille;


    /**
     * Get refArticle
     *
     * @return string
     */
    public function getRefArticle()
    {
        return $this->refArticle;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return Article
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return Article
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set prixVente
     *
     * @param float $prixVente
     *
     * @return Article
     */
    public function setPrixVente($prixVente)
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    /**
     * Get prixVente
     *
     * @return float
     */
    public function getPrixVente()
    {
        return $this->prixVente;
    }

    /**
     * Set seuilMax
     *
     * @param integer $seuilMax
     *
     * @return Article
     */
    public function setSeuilMax($seuilMax)
    {
        $this->seuilMax = $seuilMax;

        return $this;
    }

    /**
     * Get seuilMax
     *
     * @return int
     */
    public function getSeuilMax()
    {
        return $this->seuilMax;
    }

    /**
     * Set seuilMin
     *
     * @param integer $seuilMin
     *
     * @return Article
     */
    public function setSeuilMin($seuilMin)
    {
        $this->seuilMin = $seuilMin;

        return $this;
    }

    /**
     * Get seuilMin
     *
     * @return int
     */
    public function getSeuilMin()
    {
        return $this->seuilMin;
    }


    /**
     * @var float
     *
     * @ORM\Column(name="prix_vente", type="float")
     */
    private $prixVente;

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
     * @return mixed
     */
    public function getFamille()
    {
        return $this->Famille;
    }

    /**
     * @param mixed $Famille
     */
    public function setFamille($Famille)
    {
        $this->Famille = $Famille;
    }



    /**
     * Set refArticle
     *
     * @param string $refArticle
     *
     * @return Article
     */
    public function setRefArticle($refArticle)
    {
        $this->refArticle = $refArticle;

        return $this;
    }
}
