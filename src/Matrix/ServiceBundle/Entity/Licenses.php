<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Licenses
 *
 * @ORM\Table(name="licenses", uniqueConstraints={@ORM\UniqueConstraint(name="serial", columns={"serial"})},
 *                  indexes={@ORM\Index(name="Ref_04", columns={"owner"}),
 *                          @ORM\Index(name="Ref_31", columns={"distributor"})})
 * @ORM\Entity(repositoryClass="Matrix\ServiceBundle\Repository\LicensesRepository")
 */
class Licenses
{
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
     * @ORM\Column(name="serial", type="string", length=10, nullable=false)
     */
    private $serial;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_count", type="integer", nullable=false)
     */
    private $userCount = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '1';

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner", referencedColumnName="id")
     * })
     */
    private $owner;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="distributor", referencedColumnName="id")
     * })
     */
    private $distributor;

    /**
     * @param Users $distributor
     * @return Licenses
     */
    public function setDistributor($distributor)
    {
        $this->distributor = $distributor;

        return $this;
    }

    /**
     * @return Users
     */
    public function getDistributor()
    {
        return $this->distributor;
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
     * Set serial
     *
     * @param string $serial
     * @return Licenses
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return string 
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set userCount
     *
     * @param integer $userCount
     * @return Licenses
     */
    public function setUserCount($userCount)
    {
        $this->userCount = $userCount;

        return $this;
    }

    /**
     * Get userCount
     *
     * @return integer 
     */
    public function getUserCount()
    {
        return $this->userCount;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Licenses
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set owner
     *
     * @param \Matrix\ServiceBundle\Entity\Users $owner
     * @return Licenses
     */
    public function setOwner(\Matrix\ServiceBundle\Entity\Users $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Matrix\ServiceBundle\Entity\Users 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
