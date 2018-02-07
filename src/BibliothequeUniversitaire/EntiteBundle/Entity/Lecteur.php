<?php

namespace BibliothequeUniversitaire\EntiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lecteur
 */
class Lecteur
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;


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
     * Set nom
     *
     * @param string $nom
     * @return Lecteur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Lecteur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    /**
     * @var \BibliothequeUniversitaire\EntiteBundle\Entity\Faculte
     */
    private $faculte_choisie;

    /**
     * @var \BibliothequeUniversitaire\EntiteBundle\Entity\Cycle
     */
    private $cycle_choisi;


    /**
     * Set faculte_choisie
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Faculte $faculteChoisie
     * @return Lecteur
     */
    public function setFaculteChoisie(\BibliothequeUniversitaire\EntiteBundle\Entity\Faculte $faculteChoisie = null)
    {
        $this->faculte_choisie = $faculteChoisie;

        return $this;
    }

    /**
     * Get faculte_choisie
     *
     * @return \BibliothequeUniversitaire\EntiteBundle\Entity\Faculte 
     */
    public function getFaculteChoisie()
    {
        return $this->faculte_choisie;
    }

    /**
     * Set cycle_choisi
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Cycle $cycleChoisi
     * @return Lecteur
     */
    public function setCycleChoisi(\BibliothequeUniversitaire\EntiteBundle\Entity\Cycle $cycleChoisi = null)
    {
        $this->cycle_choisi = $cycleChoisi;

        return $this;
    }

    /**
     * Get cycle_choisi
     *
     * @return \BibliothequeUniversitaire\EntiteBundle\Entity\Cycle 
     */
    public function getCycleChoisi()
    {
        return $this->cycle_choisi;
    }

    public function __toString()
    {
        return $this->getNom() . " " . $this->getPrenom();
    }
}
