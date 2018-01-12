<?php

namespace Mikrotik\PlataformaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios")
 * @ORM\Entity(repositoryClass="Mikrotik\PlataformaBundle\Repository\UsuariosRepository")
 * @UniqueEntity(fields="email", message="El Email ya fue tomado por otro usuario, escoja otro Email por favor")
 */
class Usuarios implements AdvancedUserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;


    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50)
     */
    private $role;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Usuarios
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
     * Set email
     *
     * @param string $email
     *
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuarios
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

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Usuarios
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
     * Returns the roles granted to the user.
     * 
     * @return Role[] The user role
     */
    public function getRoles()
    {
        return array($this->role);
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Usuarios
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }


    public function getSalt()
    {
        return null;
    }

     public function eraseCredentials()
    {

    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
               $this->id,
               $this->username,
               $this->password,
               $this->isActive,
               $this->role,
               // ver la sección salt debajo
               // $this->salt,
             ));
     }

      /** @see \Serializable::unserialize() */
      public function unserialize($serialized)
      {
         list (
               $this->id,
               $this->username,
               $this->password,
               $this->isActive,
               $this->role,
               // ver la sección salt debajo
               // $this->salt
          ) = unserialize($serialized);
      }

      public function isAccountNonExpired()
      {
          return true;
      }

      public function isAccountNonLocked()
      {
          return true;
      }

      public function isCredentialsNonExpired()
      {
          return true;
      }

      public function isEnabled()
      {
          return $this->isActive;
      }
      
}

