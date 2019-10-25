<?php

namespace App\Models;

use Doctrine\ORM\EntityManager;

class UserRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * getUsers function
     *
     * @return $users from repository
     */
    public function getUsers()
    {
        $usersRespository = $this->entityManager->getRepository('App\Models\Entity\UserEntity');
        $users = $usersRespository->findAll();
        return $users;
    }

    public function addUser(
        string $fullname,
        string $email,
        string $password,
        bool $isActive
    )
    {
        try{
            $user = new UserEntity();
            $user->setFullName($fullname);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setIsActive($isActive);
            $user->setCreateAt();
            /**
             * @method EntityManager handler persist user
             */

            
            return $user;
        } catch (\Exception $e){
            throw new \Exception("{$e->getMessage()} : {$e->getCode()}");
        }
    }
}