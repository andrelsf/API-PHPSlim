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

    public function findByEmail($email)
    {
        $userRepository = $this->entityManager
                               ->getRepository('App\Models\Entity\UserEntity');
        $user = $userRepository->findBy(['email' => $email]);
        if ($user){
            return true;
        } else {
            return false;
        }
    }

    public function deleteOneUser($id)
    {
        $result = [];
        $userRepository = $this->entityManager
                               ->getRepository('App\Models\Entity\UserEntity');

        $users = $userRepository->findBy(['id' => (int) $id]);
        $user = $users[0];
        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            $result['message'] = "{$id} deleted with successfully";
            $result['code'] = 200;
            return $result;
        } else {
            $result['message'] = "id not found";
            $result['code'] = 404;
            return $result;
        }
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
            $result['message'] = array(
                'fullname' => $user->getFullName(),
                'email' => $user->getEmail(),
                'isactive' => $user->getIsActive(),
                'createat' => $user->getCreateAt()
                                   ->format('d/m/Y H:i:s'),
                'updateat' => $user->getUpdateAt()
            );
            $result['code'] = 200;
            return $result;
        } else {
            $result['message'] = "id not found";
            $result['code'] = 404;
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
                        'id' => $user->getId(),
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