<?php

namespace BibliothequeUniversitaire\EntiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emprunt
 */
class Emprunt
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateDebut;


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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Emprunt
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
     * @var \BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur
     */
    private $lecteur_emprunteur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $exemplaires_empruntes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->exemplaires_empruntes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set lecteur_emprunteur
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur $lecteurEmprunteur
     * @return Emprunt
     */
    public function setLecteurEmprunteur(\BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur $lecteurEmprunteur = null)
    {
        $this->lecteur_emprunteur = $lecteurEmprunteur;

        return $this;
    }

    /**
     * Get lecteur_emprunteur
     *
     * @return \BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur 
     */
    public function getLecteurEmprunteur()
    {
        return $this->lecteur_emprunteur;
    }

    /**
     * @var \BibliothequeUniversitaire\EntiteBundle\Entity\Exemplaire
     */
    private $exemplaire_emprunte;


    /**
     * Set exemplaire_emprunte
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Exemplaire $exemplaireEmprunte
     * @return Emprunt
     */
    public function setExemplaireEmprunte(\BibliothequeUniversitaire\EntiteBundle\Entity\Exemplaire $exemplaireEmprunte = null)
    {
        $this->exemplaire_emprunte = $exemplaireEmprunte;

        return $this;
    }

    /**
     * Get exemplaire_emprunte
     *
     * @return \BibliothequeUniversitaire\EntiteBundle\Entity\Exemplaire 
     */
    public function getExemplaireEmprunte()
    {
        return $this->exemplaire_emprunte;
    }
}
