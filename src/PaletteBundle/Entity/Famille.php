<?php

namespace PaletteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Famille
 *
 * @ORM\Table(name="famille")
 * @ORM\Entity
 */
class Famille
{
    /**
     * @var integer
     *
     * @ORM\Column(name="codeFamille", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codefamille;

    /**
     * @var string
     *
     * @ORM\Column(name="nomFamille", type="string", length=50, nullable=false)
     */
    private $nomfamille;


}

