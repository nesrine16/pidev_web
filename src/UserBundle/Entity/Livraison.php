<?php


namespace UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;




/**
 * Livraison
 *
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
     * @var \Livreur
     *
     * @ORM\ManyToOne(targetEntity="Livreur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="livreur", referencedColumnName="id")
     * })
     */
    private $livreur;

    /**
     * @return \Livreur
     */
    public function getLivreur()
    {
        return $this->livreur;
    }

    /**
     * @param \Livreur $livreur
     */
    public function setLivreur($livreur)
    {
        $this->livreur = $livreur;
    }

    /**
     * @return \User
     */
    public function getChefId()
    {
        return $this->chefId;
    }

    /**
     * @param \User $chefId
     */
    public function setChefId($chefId)
    {
        $this->chefId = $chefId;
    }



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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chef_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $chefId;
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param \Commande $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }






}
