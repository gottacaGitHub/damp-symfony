<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    const DEFAULT_ROLE = 'ROLE_MANAGER';
    public const SUPER_ADMIN_ROLE = 'ROLE_SUPER_ADMIN';
    public const ADMIN_ROLE = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", nullable=true)
     */
    private $password;

    /**
     * A non-persisted field that's used to create the encoded password.
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Your password must be at least {{ limit }} characters long.",
     * )
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(name="roles", type="string")
     */
    private string $roles = self::DEFAULT_ROLE;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_suspended", type="boolean")
     */
    private $isSuspended = false;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fio", type="string")
     */
    private string $fio;

    public function getId()
    {
        return $this->id;
    }

    public function getRoles()
    {
        return (array)$this->roles;
    }

    public function getRole()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;

        return $this;
    }

    public function setPlainPassword(string $plainPassword = null)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;

        return $this;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setRoles(string $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function setRole(string $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasRole($role)
    {
        return in_array(strtoupper($role), (array)$this->roles, true);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function isSuspended()
    {
        return $this->isSuspended;
    }

    public function setIsSuspended(bool $isSuspended)
    {
        $this->isSuspended = $isSuspended;

        return $this;
    }

       public function getFio(): ?string
    {
        return $this->fio;
    }

    public function setFio(string $fio): self
    {
        $this->fio = $fio;

        return $this;
    }

}
