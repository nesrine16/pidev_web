<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Famille
 *
 * @ORM\Table(name="famille")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\FamilleRepository")
 */
class Famille
{
    /**
     * @var int
     *
     * @ORM\Column(name="codeFamille", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")

     * @ORM\Id
     */
    private $codeFamille;



    /**
     * @var string
     *
     * @ORM\Column(name="nomFamille", type="string", length=255)
     */
    private $nomFamille;


    /**
     * Set codeFamille
     *
     * @param integer $codeFamille
     *
     * @return Famille
     */
    public function setCodeFamille($codeFamille)
    {
        $this->codeFamille = $codeFamille;

        return $this;
    }

    /**
     * Get codeFamille
     *
     * @return int
     */
    public function getCodeFamille()
    {
        return $this->codeFamille;
    }

    /**
     * Set nomFamille
     *
     * @param string $nomFamille
     *
     * @return Famille
     */
    public function setNomFamille($nomFamille)
    {
        $this->nomFamille = $nomFamille;

        return $this;
    }

    /**
     * Get nomFamille
     *
     * @return string
     */
    public function getNomFamille()
    {
        return $this->nomFamille;
    }
}
