<?php

namespace BibliothequeUniversitaire\EntiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Archive
 */
class Archive
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $titreAuteur;

    /**
     * @var string
     */
    private $identiteLecteur;

    /**
     * @var \DateTime
     */
    private $dateDebut;

    /**
     * @var \DateTime
     */
    private $dateRetour;


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
     * Set titreAuteur
     *
     * @param string $titreAuteur
     * @return Archive
     */
    public function setTitreAuteur($titreAuteur)
    {
        $this->titreAuteur = $titreAuteur;

        return $this;
    }

    /**
     * Get titreAuteur
     *
     * @return string 
     */
    public function getTitreAuteur()
    {
        return $this->titreAuteur;
    }

    /**
     * Set identiteLecteur
     *
     * @param string $identiteLecteur
     * @return Archive
     */
    public function setIdentiteLecteur($identiteLecteur)
    {
        $this->identiteLecteur = $identiteLecteur;

        return $this;
    }

    /**
     * Get identiteLecteur
     *
     * @return string 
     */
    public function getIdentiteLecteur()
    {
        return $this->identiteLecteur;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Archive
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateRetour
     *
     * @param \DateTime $dateRetour
     * @return Archive
     */
    public function setDateRetour($dateRetour)
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    /**
     * Get dateRetour
     *
     * @return \DateTime 
     */
    public function getDateRetour()
    {
        return $this->dateRetour;
    }
}
