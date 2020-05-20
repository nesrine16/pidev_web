<?php


namespace UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Commande
 *
 * @ORM\Entity(repositoryClass="UserBundle\Repository\CommandeRepository")
 */
class Commande
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_commande;

    /**
     * @var string
     *
     * @ORM\Column(name="num_commande", type="string", length=200, nullable=true)
     */
    private $num_commande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commande", type="date", length=255, nullable=true)
     */
    private $date_commande;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", length=255, nullable=false)
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=200, nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_livraison", type="date", length=255, nullable=true)
     */
    private $date_livraison;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\LigneCommande", mappedBy="Commande", cascade={"remove"})
     */
    private $lignes;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;

    public function calculMontant()
    {
        $montant = 0;
        foreach ($this->getLignes() as $ligne){
            $montant = $montant + ($ligne->getQte() * $ligne->getArticle()->getPrixVente());
        }

        return $montant;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lignes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdCommande()
    {
        return $this->id_commande;
    }

    /**
     * @param int $id_commande
     */
    public function setIdCommande($id_commande)
    {
        $this->id_commande = $id_commande;
    }

    /**
     * @return string
     */
    public function getNumCommande()
    {
        return $this->num_commande;
    }

    /**
     * @param string $num_commande
     */
    public function setNumCommande($num_commande)
    {
        $this->num_commande = $num_commande;
    }

    /**
     * @return \DateTime
     */
    public function getDateCommande()
    {
        return $this->date_commande;
    }

    /**
     * @param \DateTime $date_commande
     */
    public function setDateCommande($date_commande)
    {
        $this->date_commande = $date_commande;
    }

    /**
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param float $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getDateLivraison()
    {
        return $this->date_livraison;
    }

    /**
     * @param \DateTime $date_livraison
     */
    public function setDateLivraison($date_livraison)
    {
        $this->date_livraison = $date_livraison;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Add ligne
     *
     * @param \UserBundle\Entity\LigneCommande $ligne
     *
     * @return Commande
     */
    public function addLigne(\UserBundle\Entity\LigneCommande $ligne)
    {
        $this->lignes[] = $ligne;

        return $this;
    }

    /**
     * Remove ligne
     *
     * @param \UserBundle\Entity\LigneCommande $ligne
     */
    public function removeLigne(\UserBundle\Entity\LigneCommande $ligne)
    {
        $this->lignes->removeElement($ligne);
    }

    /**
     * Get lignes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignes()
    {
        return $this->lignes;
    }
}
