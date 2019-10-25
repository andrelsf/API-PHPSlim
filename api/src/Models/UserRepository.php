<?php

namespace App\Models;

use Doctrine\ORM\EntityManager;
use App\Models\Entity\UserEntity;

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
        $results = [];
        $usersRespository = $this->entityManager
                                 ->getRepository('App\Models\Entity\UserEntity');
        $users = $usersRespository->findAll();
        foreach ($users as $user){
            if (isset($user)) {
                array_push(
                    $results, array(
                        'fullname' => $user->getFullName(),
                        'email' => $user->getEmail(),
                        'isactive' => $user->getIsActive(),
                        'createat' => $user->getCreateAt()
                                           ->format('d/m/Y H:i:s'),
                        'updateat' => $user->getUpdateAt()
                    )
                );
            }
        }
        return $results;
    }

    public function addUser(
        string $fullname,
        string $email,
        string $password,
        bool $isActive
    )
    {
        try{
            $this->entityManager
                 ->getRepository('App\Models\Entity\UserEntity');
            $user = new UserEntity();
            $user->setFullName($fullname);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setIsActive($isActive);
            $user->setCreateAt();
            /**
             * @method EntityManager handler persist user
             */
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e){
            throw new \Exception("{$e->getMessage()} : {$e->getCode()}");
            return false;
        }
    }
}