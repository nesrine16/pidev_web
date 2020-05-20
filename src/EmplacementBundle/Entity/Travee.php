<?php

namespace EmplacementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Travee
 *
 * @ORM\Table(name="travee")
 * @ORM\Entity(repositoryClass="EmplacementBundle\Repository\TraveeRepository")
 */
class Travee
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numTrav", type="string", length=255)
     */
    private $numTrav;

    /**
     * @ORM\ManyToOne(targetEntity="EmplacementBundle\Entity\Allee")
     *
     * @ORM\JoinColumn(name="idAllee", referencedColumnName="id" ,nullable=true, onDelete="SET NULL")
     */

    private $allee;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAllee()
    {
        return $this->allee;
    }

    /**
     * @param mixed $allee
     */
    public function setAllee($allee)
    {
        $this->allee = $allee;
    }

    /**
     * Set numTrav
     *
     * @param string $numTrav
     *
     * @return Travee
     */
    public function setNumTrav($numTrav)
    {
        $this->numTrav = $numTrav;

        return $this;
    }

    /**
     * Get numTrav
     *
     * @return string
     */
    public function getNumTrav()
    {
        return $this->numTrav;
    }
}

