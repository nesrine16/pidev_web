<?php

namespace PaletteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Allee
 *
 * @ORM\Table(name="Allee")
 * @ORM\Entity
 */
class Allee
{
    /**
     * @var string
     *
     * @ORM\Column(name="codeAllee", type="string", length=1, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeallee;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbTravees", type="integer", nullable=false)
     */
    private $nbtravees;

    /**
     * @var integer
     *
     * @ORM\Column(name="niv", type="integer", nullable=false)
     */
    private $niv;


}

