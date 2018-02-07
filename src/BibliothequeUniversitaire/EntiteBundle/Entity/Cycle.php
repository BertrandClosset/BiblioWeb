<?php

namespace BibliothequeUniversitaire\EntiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cycle
 */
class Cycle
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var integer
     */
    private $nombreLivres;

    /**
     * @var integer
     */
    private $duree;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Cycle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set nombreLivres
     *
     * @param integer $nombreLivres
     * @return Cycle
     */
    public function setNombreLivres($nombreLivres)
    {
        $this->nombreLivres = $nombreLivres;

        return $this;
    }

    /**
     * Get nombreLivres
     *
     * @return integer 
     */
    public function getNombreLivres()
    {
        return $this->nombreLivres;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     * @return Cycle
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer 
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * toString Cycle
     *
     * @return string
     */
    public function __toString()
    {
        return $this->libelle;
    }
}
