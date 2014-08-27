<?php

namespace Matrix\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="Ref_08", columns={"user"}), @ORM\Index(name="Ref_09", columns={"customer"})})
 * @ORM\Entity(repositoryClass="Matrix\AdminBundle\Repository\OrdersRepository")
 */
class Orders
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="slip_number", type="text", nullable=true)
     */
    private $slipNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="special_code", type="text", nullable=true)
     */
    private $specialCode;



    /**
     * @var float
     *
     * @ORM\Column(name="subtotal", type="float", precision=15, scale=3, nullable=true)
     */
    private $subtotal;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=2, nullable=false)
     */
    private $total;

    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer", nullable=false)
     */
    private $version = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '1';

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer", referencedColumnName="id")
     * })
     */
    private $customer;


    /**
     * converts Orders to array
     * @return array
     */
    public function toArray(){
        return array(
            "id" => $this->getId(),
            "date" => $this->getDate()->format("d-m-Y"),
            "slipNumber" => $this->getSlipNumber(),
            "version" => $this->getVersion(),
            "status" => $this->getStatus(),
            "specialCode" => $this->getSpecialCode(),
            "subtotal" => $this->getSubtotal(),
            "total" => $this->getTotal()
        );
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
     * Set date
     *
     * @param \DateTime $date
     * @return Orders
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set slipNumber
     *
     * @param string $slipNumber
     * @return Orders
     */
    public function setSlipNumber($slipNumber)
    {
        $this->slipNumber = $slipNumber;

        return $this;
    }

    /**
     * Get slipNumber
     *
     * @return string 
     */
    public function getSlipNumber()
    {
        return $this->slipNumber;
    }

    /**
     * Set specialCode
     *
     * @param string $specialCode
     * @return Orders
     */
    public function setSpecialCode($specialCode)
    {
        $this->specialCode = $specialCode;

        return $this;
    }

    /**
     * Get specialCode
     *
     * @return string 
     */
    public function getSpecialCode()
    {
        return $this->specialCode;
    }



    /**
     * Set subtotal
     *
     * @param float $subtotal
     * @return Orders
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get subtotal
     *
     * @return float 
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Orders
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set version
     *
     * @param integer $version
     * @return Orders
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Orders
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
     * Set user
     *
     * @param \Matrix\ServiceBundle\Entity\Users $user
     * @return Orders
     */
    public function setUser(\Matrix\ServiceBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Matrix\ServiceBundle\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set customer
     *
     * @param \Matrix\ServiceBundle\Entity\Customers $customer
     * @return Orders
     */
    public function setCustomer(\Matrix\ServiceBundle\Entity\Customers $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Matrix\ServiceBundle\Entity\Customers 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
