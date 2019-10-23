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
class User {

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
    private $name;

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
     * @var bool  #TODO
     * @column(type="")
     */

    /**
     * @var DateTime
     * @column(type="datetime", name="create_at")
     */
    private $create_at;

    /**
     * @var DateTime
     * @column(type="datetime", name="update_at")
     */
    private $update_at;

}