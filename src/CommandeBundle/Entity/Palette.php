<?php

namespace CommandeBundle\Entity;

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
     */
    private $numLot;

    /**
     * @var integer
     *
     * @ORM\Column(name="qte", type="integer", nullable=false)
     */
    private $qte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration", type="date", nullable=false)
     */
    private $dateExpiration;

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
     * @var \Emplacement
     *
     * @ORM\ManyToOne(targetEntity="Emplacement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codeEmp", referencedColumnName="codeEmp")
     * })
     */
    private $codeemp;


}

