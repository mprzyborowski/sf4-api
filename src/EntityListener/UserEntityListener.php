<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserEntityListener
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function prePersist(User $object): void
    {
        $this->encodePassword($object);
    }

    public function preUpdate(User $object): void
    {
        $this->encodePassword($object);
    }

    private function encodePassword(User $object): void
    {
        if (null !== $object->getPlainPassword()) {
            $password = $this->userPasswordEncoder->encodePassword($object, $object->getPlainPassword());
            $object->setPassword($password);
        }
    }

}