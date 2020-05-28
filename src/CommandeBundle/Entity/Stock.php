<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock", indexes={@ORM\Index(name="num_palette", columns={"num_palette"})})
 * @ORM\Entity
 */
class Stock
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_stock", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStock;

    /**
     * @var integer
     *
     * @ORM\Column(name="qte_physique", type="integer", nullable=false)
     */
    private $qtePhysique;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=191, nullable=false)
     */
    private $etat;

    /**
     * @var \Palette
     *
     * @ORM\ManyToOne(targetEntity="Palette")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="num_palette", referencedColumnName="num_lot")
     * })
     */
    private $numPalette;


}

