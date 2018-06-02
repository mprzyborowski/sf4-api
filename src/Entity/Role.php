<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity
 * @ORM\EntityListeners({"App\EntityListener\UserEntityListener"})
 * @ORM\Table(name="user")
 * @ApiResource(
 *     attributes={
 *      "normalization_context"={"groups"={"api_user_read"}},
 *      "denormalization_context"={"groups"={"api_user_write"}},
 *      "order"={"id"="DESC"}
 *     },itemOperations={
 *      "delete"={"access_control"="is_granted('ROLE_ADMIN')"},
 *      "put"={"access_control"="is_granted('ROLE_USER')"},
 *      "get"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     }, collectionOperations={
 *     "get"={"access_control"="is_granted('ROLE_USER')"}
 *     })
 */
class Role implements UserInterface
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

    public function __construct()
    {
        $this->setRoles(['ROLE_USER']);
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
     * @param string $email
     */
    public function setUsername(string $email): void
    {
        $this->email = $email;
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
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     */
    public function eraseCredentials()
    {
    }


}