<?php

namespace BibliothequeUniversitaire\EntiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 */
class Reservation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateReservation;


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
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     * @return Reservation
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime 
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }
    /**
     * @var \BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur
     */
    private $lecteurs_reservant;

    /**
     * @var \BibliothequeUniversitaire\EntiteBundle\Entity\Livre
     */
    private $livre_reserve;


    /**
     * Set lecteurs_reservant
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur $lecteursReservant
     * @return Reservation
     */
    public function setLecteursReservant(\BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur $lecteursReservant = null)
    {
        $this->lecteurs_reservant = $lecteursReservant;

        return $this;
    }

    /**
     * Get lecteurs_reservant
     *
     * @return \BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur 
     */
    public function getLecteursReservant()
    {
        return $this->lecteurs_reservant;
    }

    /**
     * Set livre_reserve
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livreReserve
     * @return Reservation
     */
    public function setLivreReserve(\BibliothequeUniversitaire\EntiteBundle\Entity\Livre $livreReserve = null)
    {
        $this->livre_reserve = $livreReserve;

        return $this;
    }

    /**
     * Get livre_reserve
     *
     * @return \BibliothequeUniversitaire\EntiteBundle\Entity\Livre 
     */
    public function getLivreReserve()
    {
        return $this->livre_reserve;
    }
}
