<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Devices
 *
 * @ORM\Table(name="devices", indexes={@ORM\Index(name="Ref_26", columns={"license"}), @ORM\Index(name="Ref_27", columns={"user"})})
 * @ORM\Entity(repositoryClass="Matrix\ServiceBundle\Repository\DevicesRepository")
 */
class Devices
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
     * @ORM\Column(name="uuid", type="text", nullable=false)
     */
    private $uuid;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '1';

    /**
     * @var Licenses
     *
     * @ORM\ManyToOne(targetEntity="Licenses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="license", referencedColumnName="id")
     * })
     */
    private $license;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;



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
     * Set uuid
     *
     * @param string $uuid
     * @return Devices
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Devices
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
     * Set license
     *
     * @param Licenses $license
     * @return Devices
     */
    public function setLicense(Licenses $license = null)
    {
        $this->license = $license;

        return $this;
    }

    /**
     * Get license
     *
     * @return Licenses
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Set user
     *
     * @param Users $user
     * @return Devices
     */
    public function setUser(Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Users
     */
    public function getUser()
    {
        return $this->user;
    }
}
