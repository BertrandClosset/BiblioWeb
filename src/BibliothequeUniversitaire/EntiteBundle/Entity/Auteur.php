<?php

namespace BibliothequeUniversitaire\EntiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Auteur
 */
class Auteur
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
     * @return Auteur
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
     * @return Auteur
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $livres_ecrits;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->livres_ecrits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add livres_ecrits
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresEcrits
     * @return Auteur
     */
    public function addLivresEcrit(\BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresEcrits)
    {
        $this->livres_ecrits[] = $livresEcrits;
        $livresEcrits->addAuteursInscrit($this);
        return $this;
    }

    /**
     * Remove livres_ecrits
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresEcrits
     */
    public function removeLivresEcrit(\BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresEcrits)
    {
        $this->livres_ecrits->removeElement($livresEcrits);
    }

    /**
     * Get livres_ecrits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLivresEcrits()
    {
        return $this->livres_ecrits;
    }

    /**
     * toString Auteur
     *
     * @return string
     */
    public function __toString()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
