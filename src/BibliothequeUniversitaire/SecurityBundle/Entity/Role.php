<?php

namespace BibliothequeUniversitaire\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Role
 */
class Role implements RoleInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add users
     *
     * @param \BibliothequeUniversitaire\SecurityBundle\Entity\User $users
     * @return Role
     */
    public function addUser(\BibliothequeUniversitaire\SecurityBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \BibliothequeUniversitaire\SecurityBundle\Entity\User $users
     */
    public function removeUser(\BibliothequeUniversitaire\SecurityBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function __toString()
    {
        return $this->getRole();
    }
}
