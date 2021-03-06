<?php

namespace Matrix\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserType
 *
 * @ORM\Table(name="user_type")
 * @ORM\Entity
 */
class UserType
{

    const ADMIN = 1;

    const DISTRIBUTOR = 2;

    const ACCOUNT_OWNER = 3;

    const MANAGER = 4;

    const MOBILE_USER = 5;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     */
    private $name;


    /**
     * @param $roleId
     * @return string
     */
    public static function getRole($roleId){
        switch($roleId){
            case self::ADMIN:
                return "ROLE_ADMIN";
            case self::DISTRIBUTOR:
                return "ROLE_DISTRIBUTOR";
            case self::ACCOUNT_OWNER:
                return "ROLE_ACCOUNT_OWNER";
            case self::MANAGER:
                return "ROLE_MANAGER";
            case self::MOBILE_USER:
                return "ROLE_MOBILE_USER";
            default:
                return "ROLE_ANONYMOUS";
        }
    }



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return UserType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
