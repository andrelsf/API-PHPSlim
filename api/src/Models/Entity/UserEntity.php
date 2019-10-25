<?php

namespace App\Models\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Entity @Table(name="users")
 */
class UserEntity {

    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @column(type="string", nullable=false)
     */
    private $fullname;

    /**
     * @var string
     * @column(type="string", nullable=false, unique=true)
     */
    private $email;

    /**
     * @var string
     * @column(type="string", nullable=false)
     */
    private $password;

    /**
     * @var bool
     * @column(type="boolean", nullable=false, name="isactive")
     */
    private $isActive;

    /**
     * @var DateTime
     * @column(type="datetime", nullable=true, name="createat")
     */
    private $createAt;

    /**
     * @var DateTime
     * @column(type="datetime", nullable=true, name="updateat")
     */
    private $updateAt;

    /**
     * Methods GETTERs and SETTERs
     */

    public function getId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->fullname;
    }

    public function setFullName($fullname)
    {
        if ($this->verifyField($fullname)) {
            $this->fullname = $fullname;
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if ($this->verifyField($email)) {
            $this->email = $email;
        }
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if ($this->verifyField($password)){
            $this->password = hash("sha256", $password);    
        }
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        if (!is_bool($isActive)) {
            throw new \InvalidArgumentException(
                "isActive is required", 400
            );
        }
        $this->isActive = $isActive;
        return $this;
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }

    public function setCreateAt()
    {
        $this->createAt = new \DateTime("now");
    }

    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    public function setUpdateAt()
    {
        $this->updateAt = new \Datetime("now");
    }

    private function verifyField($field)
    {
        if (!$field && !is_string($field)){
            throw new \InvalidArgumentException(
                "{$field} is required", 400
            );
        }
        return true;
    }
}