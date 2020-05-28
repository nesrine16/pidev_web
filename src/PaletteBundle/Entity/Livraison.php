<?php

namespace PaletteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livraison
 *
 * @ORM\Table(name="livraison", indexes={@ORM\Index(name="IDX_A60C9F1FEB7A4E6D", columns={"livreur"}), @ORM\Index(name="IDX_A60C9F1F6EEAA67D", columns={"commande"}), @ORM\Index(name="IDX_A60C9F1F150A48F1", columns={"chef_id"})})
 * @ORM\Entity
 */
class Livraison
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
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chef_id", referencedColumnName="id")
     * })
     */
    private $chef;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="commande", referencedColumnName="id_commande")
     * })
     */
    private $commande;

    /**
     * @var \Livreur
     *
     * @ORM\ManyToOne(targetEntity="Livreur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="livreur", referencedColumnName="id")
     * })
     */
    private $livreur;


}

