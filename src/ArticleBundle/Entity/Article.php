<?php

namespace trackBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 * @ORM\Entity(repositoryClass="trackBundle\Repository\ArticleRepository")
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
     * @var integer
     *
     * @ORM\Column(name="code", type="integer")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=255)
     */
    private $designation;


    /**
     * @var string
     *
     * @ORM\Column(name="unite", type="string", length=255)
     */
    private $unite;


    /**
     * @var float
     *
     * @ORM\Column(name="prix_achat", type="float")
     */
    private $prixAchat;


    /**
     * @var float
     *
     * @ORM\Column(name="prix_vente", type="float")
     */
    private $prixVente;


    /**
     * @var integer
     *
     * @ORM\Column(name="seuil_max", type="integer")
     */


    private $seuilMax;

    /**
     * @var integer
     *
     * @ORM\Column(name="seuil_min", type="integer")
     */
    private $seuilMin;

    /**
     * @ORM\ManyToOne(targetEntity="trackBundle\Entity\Fournisseur")
     *
     * @ORM\JoinColumn(name="fournisseur", referencedColumnName="id" ,nullable=true, onDelete="SET NULL")
     */
    private $fournisseur;

    /**
     * @ORM\ManyToOne(targetEntity="FamilleBundle\Entity\Famille")
     *
     * @ORM\JoinColumn(name="famille", referencedColumnName="codeFamille" ,nullable=true, onDelete="SET NULL")
     */
    private $famille;

    /**
     * @return mixed
     */
    public function getFamille()
    {
        return $this->famille;
    }






  //  public function getImg()
    //{
      //  return $this->img;
    //}

    ///**
     //* @param string $img
     //*/
    //public function setImg($img)
    //{
        //$this->img = $img;
    //}

   /* /**
     * @var string
     *
     * @ORM\Column(name="img", type="string")
     */
    /* private $img; */





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
     * @param mixed $famille
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;
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
     * Set unite
     *
     * @param string $unite
     *
     * @return Article
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;

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
     * Get unite
     *
     * @return string
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * @return mixed
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * @param mixed $fournisseur
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;
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

