<?php

namespace EmplacementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Allee
 *
 * @ORM\Table(name="allee")
 * @ORM\Entity(repositoryClass="EmplacementBundle\Repository\AlleeRepository")
 */
class Allee
{ /**
 * @var integer
 *
 * @ORM\Column(name="id", type="integer")
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="AUTO")
 */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ligne", type="string", length=255, unique=true)
     */
    private $ligne;


    /**
     * @return int
     */
    public function getNbTrav()
    {
        return $this->nbTrav;
    }

    /**
     * @param int $nbTrav
     */
    public function setNbTrav($nbTrav)
    {
        $this->nbTrav = $nbTrav;
    }

    /**
     * @return string
     */


    /**
     * @var int
     *
     * @ORM\Column(name="nbTrav", type="integer")
     */
    private $nbTrav;


    /**
     * @var int
     *
     * @ORM\Column(name="niv", type="integer")
     */
    private $niv;

    /**
     * @return int
     */
    public function getNiv()
    {
        return $this->niv;
    }

    /**
     * @param int $niv
     */
    public function setNiv($niv)
    {
        $this->niv = $niv;
    }

    /**
     * @return string
     */
    public function getLigne()
    {
        return $this->ligne;
    }

    /**
     * @param string $ligne
     */
    public function setLigne($ligne)
    {
        $this->ligne = $ligne;
    }


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
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}

