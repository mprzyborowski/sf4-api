<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity
 * @ORM\EntityListeners({"App\EntityListener\UserEntityListener"})
 * @ORM\Table(name="user")
 * @UniqueEntity("username")
 * @ApiResource(
 *     attributes={
 *      "normalization_context"={"groups"={"api_user_read"}},
 *      "denormalization_context"={"groups"={"api_user_write"}},
 *      "order"={"id"="DESC"}
 *     },itemOperations={
 *      "delete"={"access_control"="is_granted('ROLE_ADMIN')"},
 *      "put"={"access_control"="is_granted('ROLE_USER')"},
 *      "get"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     })
 */
class User implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     * @Groups({"api_user_read"})
     */
    private $id;
    /**
     * @var string
     * @Assert\Email()
     * @ORM\Column(type="string")
     * @Groups({"api_user_read", "api_user_write"})
     */
    private $email;
    /**
     * @var string
     * @Groups({"api_user_write"})
     */
    private $plainPassword;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Skill", mappedBy="user")
     */
    private $skills;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->skills = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }


    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getSkills()
    {
        return $this->skills;
    }

    public function setSkills($skills): void
    {
        $this->skills = $skills;
    }


}