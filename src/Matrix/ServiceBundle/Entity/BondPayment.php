<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="bond_payment",
 *      indexes={@ORM\Index(name="Ref_62", columns={"mobile_user"}),
 * @ORM\Index(name="Ref_63", columns={"currency"}),
 * @ORM\Index(name="Ref_64", columns={"customer"})})
 * @ORM\Entity(repositoryClass="Matrix\ServiceBundle\Repository\BondPaymentRepository")
 */
class BondPayment
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
     * @var string
     *
     * @ORM\Column(name="issuer_name", type="string", length=50, nullable=true)
     */
    private $issuerName;

    /**
     * @var string
     *
     * @ORM\Column(name="guarantor_name", type="string", length=50, nullable=true)
     */
    private $guarantorName;



    /**
     * @var integer
     *
     * @ORM\Column(name="serial_number", type="string", length=50, nullable=true)
     */
    private $serialNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $dueDate;



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
            "customer_id" => $this->getCustomer()->getId(),
            "issuer_name" => $this->getIssuerName(),
            "serial_number" => $this->getSerialNumber(),
            "due_date" => $this->getDueDate()->format("d-m-Y"),
            "guarantor_name" => $this->getGuarantorName()
        );
    }



    /**
     * @param float $amount
     * @return BondPayment
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
     * @param int $cardNumber
     * @return BondPayment
     */
    public function setSerialNumber($cardNumber)
    {
        $this->serialNumber = $cardNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @param Currency $currency
     * @return BondPayment
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
     * @return BondPayment
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
     * @param string $guarantorName
     * @return BondPayment
     */
    public function setGuarantorName($guarantorName)
    {
        $this->guarantorName = $guarantorName;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuarantorName()
    {
        return $this->guarantorName;
    }

    /**
     * @param \DateTime $date
     * @return BondPayment
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
     * @return BondPayment
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
     * @param \DateTime $expiresDate
     * @return BondPayment
     */
    public function setDueDate($expiresDate)
    {
        $this->dueDate = $expiresDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param string $holdersName
     * @return BondPayment
     */
    public function setIssuerName($holdersName)
    {
        $this->issuerName = $holdersName;

        return $this;
    }

    /**
     * @return string
     */
    public function getIssuerName()
    {
        return $this->issuerName;
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
     * @return BondPayment
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
     * @return BondPayment
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
     * @return BondPayment
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
     * @return BondPayment
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
     * @return BondPayment
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
