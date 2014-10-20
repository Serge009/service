<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="cash_payment",
 *      indexes={@ORM\Index(name="Ref_65", columns={"mobile_user"}),
 * @ORM\Index(name="Ref_66", columns={"currency"}),
 * @ORM\Index(name="Ref_67", columns={"customer"})})
 * @ORM\Entity(repositoryClass="Matrix\ServiceBundle\Repository\CashPaymentRepository")
 */
class CashPayment
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
     * @ORM\Column(name="slip_number", type="string", length=50, nullable=true)
     */
    private $slipNumber;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;


    /**
     * @var string
     *
     * @ORM\Column(name="special_code", type="string", length=50, nullable=true)
     */
    private $specialCode;

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
     * @ORM\Column(name="amount", type="float", precision=15, scale=3, nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=150, nullable=true)
     */
    private $description;



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
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mobile_user", referencedColumnName="id")
     * })
     */
    private $mobileUser;

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



    public function toArray(){
        return array(
            "id" => $this->getId(),
            "version" => $this->getVersion(),
            "status" => $this->getStatus(),
            "slip_number" => $this->getSlipNumber(),
            "date" => $this->getDate()->format("d-m-Y"),
            "special_code" => $this->getSpecialCode(),
            "currency_id" => $this->getCurrency()->getId(),
            "amount" => $this->getAmount(),
            "description" => $this->getDescription(),
            "customer_id" => $this->getCustomer()->getId()
        );
    }


    /**
     * @param float $amount
     * @return CashPayment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }



    /**
     * @param Currency $currency
     * @return CashPayment
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
     * @param Customers $customer
     *
     * @return CashPayment
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Customers
     */
    public function getCustomer()
    {
        return $this->customer;
    }



    /**
     * @param \DateTime $date
     * @return CashPayment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $description
     * @return CashPayment
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Users $mobileUser
     * @return CashPayment
     */
    public function setMobileUser($mobileUser)
    {
        $this->mobileUser = $mobileUser;

        return $this;
    }

    /**
     * @return Users
     */
    public function getMobileUser()
    {
        return $this->mobileUser;
    }

    /**
     * @param string $slipNumber
     * @return CashPayment
     */
    public function setSlipNumber($slipNumber)
    {
        $this->slipNumber = $slipNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlipNumber()
    {
        return $this->slipNumber;
    }

    /**
     * @param string $specialCode
     * @return CashPayment
     */
    public function setSpecialCode($specialCode)
    {
        $this->specialCode = $specialCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getSpecialCode()
    {
        return $this->specialCode;
    }

    /**
     * @param int $status
     * @return CashPayment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $version
     * @return CashPayment
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }



}
