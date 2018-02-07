<?php

namespace BibliothequeUniversitaire\EntiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exemplaire
 */
class Exemplaire
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $cote;


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
     * Set cote
     *
     * @param string $cote
     * @return Exemplaire
     */
    public function setCote($cote)
    {
        $this->cote = $cote;

        return $this;
    }

    /**
     * Get cote
     *
     * @return string 
     */
    public function getCote()
    {
        return $this->cote;
    }
    /**
     * @var \BibliothequeUniversitaire\EntiteBundle\Entity\Livre
     */
    private $livres_dupliques;


    /**
     * Set livres_dupliques
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresDupliques
     * @return Exemplaire
     */
    public function setLivresDupliques(\BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livresDupliques = null)
    {
        $this->livres_dupliques = $livresDupliques;

        return $this;
    }

    /**
     * Get livres_dupliques
     *
     * @return \BibliothequeUniversitaire\EntiteBundle\Entity\Livre 
     */
    public function getLivresDupliques()
    {
        return $this->livres_dupliques;
    }

    public function __toString()
    {
        return $this->getCote();
    }
}
