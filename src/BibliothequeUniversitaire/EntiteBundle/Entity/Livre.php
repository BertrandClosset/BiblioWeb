<?php

namespace BibliothequeUniversitaire\EntiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livre
 */
class Livre
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $notice;

    /**
     * @var integer
     */
    private $nombreExemplaires;


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
     * Set titre
     *
     * @param string $titre
     * @return Livre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set notice
     *
     * @param string $notice
     * @return Livre
     */
    public function setNotice($notice)
    {
        $this->notice = $notice;

        return $this;
    }

    /**
     * Get notice
     *
     * @return string 
     */
    public function getNotice()
    {
        return $this->notice;
    }

    /**
     * Set nombreExemplaires
     *
     * @param integer $nombreExemplaires
     * @return Livre
     */
    public function setNombreExemplaires($nombreExemplaires)
    {
        $this->nombreExemplaires = $nombreExemplaires;

        return $this;
    }

    /**
     * Get nombreExemplaires
     *
     * @return integer 
     */
    public function getNombreExemplaires()
    {
        return $this->nombreExemplaires;
    }
    /**
     * @ORM\OrderBy({"prenom" = "ASC", "nom" = "ASC"})
     * @var \Doctrine\Common\Collections\Collection
     */
    private $auteurs_inscrits;

    /**
     * @ORM\OrderBy({"libelle" = "ASC"})
     * @var \Doctrine\Common\Collections\Collection
     */
    private $themes_associes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->auteurs_inscrits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->themes_associes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add auteurs_inscrits
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Auteur $auteursInscrits
     * @return Livre
     */
    public function addAuteursInscrit(\BibliothequeUniversitaire\EntiteBundle\Entity\Auteur $auteursInscrits)
    {
        $this->auteurs_inscrits[] = $auteursInscrits;

        return $this;
    }

    /**
     * Remove auteurs_inscrits
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Auteur $auteursInscrits
     */
    public function removeAuteursInscrit(\BibliothequeUniversitaire\EntiteBundle\Entity\Auteur $auteursInscrits)
    {
        $this->auteurs_inscrits->removeElement($auteursInscrits);
    }

    /**
     * Get auteurs_inscrits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuteursInscrits()
    {
        return $this->auteurs_inscrits;
    }

    /**
     * Add themes_associes
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Theme $themesAssocies
     * @return Livre
     */
    public function addThemesAssocy(\BibliothequeUniversitaire\EntiteBundle\Entity\Theme $themesAssocies)
    {
        $this->themes_associes[] = $themesAssocies;

        return $this;
    }

    /**
     * Remove themes_associes
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Theme $themesAssocies
     */
    public function removeThemesAssocy(\BibliothequeUniversitaire\EntiteBundle\Entity\Theme $themesAssocies)
    {
        $this->themes_associes->removeElement($themesAssocies);
    }

    /**
     * Get themes_associes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThemesAssocies()
    {
        return $this->themes_associes;
    }

    /**
     * toString Livre
     *
     * @return string
     */
    public function __toString()
    {
        return $this->titre;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $exemplaires_produits;


    /**
     * Add exemplaires_produits
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Exemplaire $exemplairesProduits
     * @return Livre
     */
    public function addExemplairesProduit(\BibliothequeUniversitaire\EntiteBundle\Entity\Exemplaire $exemplairesProduits)
    {
        $this->exemplaires_produits[] = $exemplairesProduits;

        return $this;
    }

    /**
     * Remove exemplaires_produits
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Exemplaire $exemplairesProduits
     */
    public function removeExemplairesProduit(\BibliothequeUniversitaire\EntiteBundle\Entity\Exemplaire $exemplairesProduits)
    {
        $this->exemplaires_produits->removeElement($exemplairesProduits);
    }

    /**
     * Get exemplaires_produits
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExemplairesProduits()
    {
        return $this->exemplaires_produits;
    }
}
