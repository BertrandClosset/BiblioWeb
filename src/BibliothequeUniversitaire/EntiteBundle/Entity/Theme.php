<?php

namespace BibliothequeUniversitaire\EntiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 */
class Theme
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
     * @var string
     */
    private $description;


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
     * @return Theme
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
     * Set description
     *
     * @param string $description
     * @return Theme
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $livres_associes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->livres_associes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add livres_associes
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresAssocies
     * @return Theme
     */
    public function addLivresAssocy(\BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresAssocies)
    {
        $this->livres_associes[] = $livresAssocies;

        return $this;
    }

    /**
     * Remove livres_associes
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresAssocies
     */
    public function removeLivresAssocy(\BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresAssocies)
    {
        $this->livres_associes->removeElement($livresAssocies);
    }

    /**
     * Get livres_associes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLivresAssocies()
    {
        return $this->livres_associes;
    }

    /**
     * toString Theme
     *
     * @return string
     */
    public function __toString()
    {
        return $this->libelle;
    }
}
