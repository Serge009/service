<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="Ref_08", columns={"user"}),
 *                                   @ORM\Index(name="Ref_09", columns={"customer"}),
 *                                   @ORM\Index(name="Ref_32", columns={"department"}),
 *                                   @ORM\Index(name="Ref_33", columns={"warehouse"}),
 *                                   @ORM\Index(name="Ref_34", columns={"plant"}),
 *                                   @ORM\Index(name="Ref_35", columns={"division"}),
*                                    @ORM\Index(name="Ref_36", columns={"currency"})
 * })
 * @ORM\Entity(repositoryClass="Matrix\ServiceBundle\Repository\OrdersRepository")
 */
class Orders
{

    /**
     * @var Department
     *
     * @ORM\ManyToOne(targetEntity="Department")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="department", referencedColumnName="id")
     * })
     */
    private $department;


    /**
     * @var Warehouse
     *
     * @ORM\ManyToOne(targetEntity="Warehouse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="warehouse", referencedColumnName="id")
     * })
     */
    private $warehouse;

    /**
     * @var Plant
     *
     * @ORM\ManyToOne(targetEntity="Plant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plant", referencedColumnName="id")
     * })
     */
    private $plant;

    /**
     * @var Division
     *
     * @ORM\ManyToOne(targetEntity="Division")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="division", referencedColumnName="id")
     * })
     */
    private $division;

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
     * @ORM\Column(name="date", type="datetime", nullable=false)
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
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var Currency
     *
     * @ORM\ManyToOne(targetEntity="Currency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency", referencedColumnName="id")
     * })
     */
    private $currency;


    /**
     * @var float
     *
     * @ORM\Column(name="advanced_payment", type="float", precision=15, scale=3, nullable=true)
     */
    private $advancedPayment;


    private $orderItems = array();

    /**
     * @param Currency $currency
     *
     * @return Orders
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }





    /**
     * @param float $advancedPayment
     * @return Orders
     */
    public function setAdvancedPayment($advancedPayment)
    {
        $this->advancedPayment = $advancedPayment;

        return $this;
    }

    /**
     * @return float
     */
    public function getAdvancedPayment()
    {
        return $this->advancedPayment;
    }



    /**
     * @param array $orderItems
     * @return Orders
     */
    public function setOrderItems($orderItems)
    {
        $this->orderItems = $orderItems;

        return $this;
    }

    /**
     * @return array
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }




    /**
     * converts Orders to array
     * @return array
     */
    public function toArray(){

        $items = array();
        foreach($this->getOrderItems() as $item){
            array_push($items, $item->toArray());
        }

        return array(
            "id" => $this->getId(),
            "date" => $this->getDate()->format("d-m-Y"),
            "slip_number" => $this->getSlipNumber(),
            "version" => $this->getVersion(),
            "status" => $this->getStatus(),
            "special_code" => $this->getSpecialCode(),
            "subtotal" => $this->getSubtotal(),
            "total" => $this->getTotal(),
            "customer" => $this->getCustomer()->getId(),
            "division" => $this->getDivision()->getId(),
            "department" => $this->getDepartment()->getId(),
            "plant" => $this->getPlant()->getId(),
            "warehouse" => $this->getWarehouse()->getId(),
            "advance_payment" => $this->getAdvancedPayment()
            //"orderItems" => $items
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
     * @param Department $department
     * @return Orders
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param Division $division
     * @return Orders
     */
    public function setDivision($division)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * @return Division
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * @param Plant $plant
     * @return Orders
     */
    public function setPlant($plant)
    {
        $this->plant = $plant;

        return $this;
    }

    /**
     * @return Plant
     */
    public function getPlant()
    {
        return $this->plant;
    }

    /**
     * @param Warehouse $warehouse
     * @return Orders
     */
    public function setWarehouse($warehouse)
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    /**
     * @return Warehouse
     */
    public function getWarehouse()
    {
        return $this->warehouse;
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
     * @param Users $user
     * @return Orders
     */
    public function setUser(Users $user)
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

    /**
     * Set customer
     *
     * @param Customers $customer
     * @return Orders
     */
    public function setCustomer(Customers $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return Customers
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
