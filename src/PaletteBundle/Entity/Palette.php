<?php

namespace PaletteBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Palette
 *
 * @ORM\Table(name="Palette", indexes={@ORM\Index(name="ref_article", columns={"ref_article"}), @ORM\Index(name="codeEmp", columns={"codeEmp"})})
 * @ORM\Entity
 */
class Palette
{
    /**
     * @var integer
     *
     * @ORM\Column(name="num_lot", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $numLot;

    /**
     * @var integer
     *
     * @ORM\Column(name="qte", type="integer", nullable=false)
     *  @Assert\NotBlank(message="Ce champs est obligatoire")
     *  @Assert\GreaterThan(
     *     value=0,
     * )
     */
    private $qte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration", type="date", nullable=false)
     */
    private $dateExpiration;



    /**
     * @var \Emplacement
     *
     * @ORM\ManyToOne(targetEntity="Emplacement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codeEmp", referencedColumnName="codeEmp")
     * })
     * @Assert\NotBlank
     */
    private $codeemp;



    /**
     * @var \Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_article", referencedColumnName="ref_article")
     * })
     */
    private $refArticle;





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
     * @return int
     */
    public function getNumLot()
    {
        return $this->numLot;
    }

    /**
     * @param int $numLot
     */
    public function setNumLot($numLot)
    {
        $this->numLot = $numLot;
    }

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
     * @return \DateTime
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * @param \DateTime $dateExpiration
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;
    }



    /**
     * @return \Emplacement
     */
    public function getCodeemp()
    {
        return $this->codeemp;
    }

    /**
     * @param \Emplacement $codeemp
     */
    public function setCodeemp($codeemp)
    {
        $this->codeemp = $codeemp;
    }




}

