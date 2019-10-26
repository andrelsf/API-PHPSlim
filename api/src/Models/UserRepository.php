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
     * getOneUser function
     *
     * @param [integer] $id
     * @return void
     */
    public function getOneUser($id)
    {
        $result = [];
        $userRepository = $this->entityManager
                               ->getRepository('App\Models\Entity\UserEntity');
        $user = $userRepository->find($id);
        if ($user) {
            array_push(
                $result,
                array(
                    'fullname' => $user->getFullName(),
                    'email' => $user->getEmail(),
                    'isactive' => $user->getIsActive(),
                    'createat' => $user->getCreateAt()
                                       ->format('d/m/Y H:i:s'),
                    'updateat' => $user->getUpdateAt()
                )
            );
            return $result;
        } else {
            array_push(
                $result,
                "ID not found"
            );
            return $result;
        }        
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
                    $results, 
                    array(
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

    /**
     * addUser function
     *
     * @param string $fullname
     * @param string $email
     * @param string $password
     * @param boolean $isActive
     * @return void
     */
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