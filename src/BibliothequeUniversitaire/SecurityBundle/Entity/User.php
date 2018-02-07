<?php

namespace BibliothequeUniversitaire\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;


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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return '';
    }

    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function eraseCredentials() { }

    public function serialize()
    {
        return serialize(array($this->id, $this->username, $this->password));
    }

    public function unserialize($serialized)
    {
        list($this->id, $this->username, $this->password) = unserialize($serialized);
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $roles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add roles
     *
     * @param \BibliothequeUniversitaire\SecurityBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\BibliothequeUniversitaire\SecurityBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \BibliothequeUniversitaire\SecurityBundle\Entity\Role $roles
     */
    public function removeRole(\BibliothequeUniversitaire\SecurityBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }
    /**
     * @var \BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur
     */
    private $lecteur_associe;


    /**
     * Set lecteur_associe
     *
     * @param \BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur $lecteurAssocie
     * @return User
     */
    public function setLecteurAssocie(\BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur $lecteurAssocie = null)
    {
        $this->lecteur_associe = $lecteurAssocie;

        return $this;
    }

    /**
     * Get lecteur_associe
     *
     * @return \BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur 
     */
    public function getLecteurAssocie()
    {
        return $this->lecteur_associe;
    }
}
