<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emplacement
 *
 * @ORM\Table(name="Emplacement", indexes={@ORM\Index(name="fkAllee", columns={"fkAllee"}), @ORM\Index(name="fkFamille", columns={"fkFamille"})})
 * @ORM\Entity
 */
class Emplacement
{
    /**
     * @var string
     *
     * @ORM\Column(name="codeEmp", type="string", length=200, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeemp;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=50, nullable=false)
     */
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     */
    private $etat;

    /**
     * @var \Allee
     *
     * @ORM\ManyToOne(targetEntity="Allee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkAllee", referencedColumnName="codeAllee")
     * })
     */
    private $fkallee;

    /**
     * @var \Famille
     *
     * @ORM\ManyToOne(targetEntity="Famille")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkFamille", referencedColumnName="codeFamille")
     * })
     */
    private $fkfamille;


}

