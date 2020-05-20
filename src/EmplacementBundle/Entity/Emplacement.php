<?php

namespace EmplacementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emplacement
 *
 * @ORM\Table(name="emplacement")
 * @ORM\Entity(repositoryClass="EmplacementBundle\Repository\EmplacementRepository")
 */
class Emplacement
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
 * @ORM\Column(name="intitule", type="string", length=255)
 */
    private $intitule;


    /**
     * @ORM\ManyToOne(targetEntity="EmplacementBundle\Entity\Allee" )
     *
     * @ORM\JoinColumn(name="idAllee", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $allee;




    /**
     * @ORM\ManyToOne(targetEntity="FamilleBundle\Entity\Famille" )
     *
     * @ORM\JoinColumn(name="codeFamille", referencedColumnName="codeFamille", nullable=true, onDelete="SET NULL")
     */
    private $famille;

    /**
     * @return mixed
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * @param mixed $famille
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;
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
     * @var string
     *
     * @ORM\Column(name="codeEmp", type="string", length=255)
     */
    private $codeEmp;

    /**
     * @return string
     */
    public function getCodeEmp()
    {
        return $this->codeEmp;
    }

    /**
     * @param string $codeEmp
     */
    public function setCodeEmp($codeEmp)
    {
        $this->codeEmp = $codeEmp;
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
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;
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
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Emplacement
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set idAllee
     *
     * @param integer $idAllee
     *
     * @return Emplacement
     */
    public function setIdAllee($idAllee)
    {
        $this->idAllee = $idAllee;

        return $this;
    }




}

