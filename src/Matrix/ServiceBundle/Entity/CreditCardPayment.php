<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoices
 *
 * @ORM\Table(name="credit_card_payment",
 *      indexes={@ORM\Index(name="Ref_56", columns={"mobile_user"}),
 * @ORM\Index(name="Ref_57", columns={"currency"}),
 * @ORM\Index(name="Ref_58", columns={"customer"})})
 * @ORM\Entity(repositoryClass="Matrix\ServiceBundle\Repository\CreditCardPaymentRepository")
 */
class CreditCardPayment
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
     * @ORM\Column(name="holders_name", type="string", length=150, nullable=true)
     */
    private $holdersName;

    /**
     * @var integer
     *
     * @ORM\Column(name="card_number", type="integer", nullable=true)
     */
    private $cardNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_date", type="datetime", nullable=true)
     */
    private $expiresDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="cvv_code", type="integer", nullable=true)
     */
    private $cvvCode;


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
            "holder_name" => $this->getHoldersName(),
            "number" => $this->getCardNumber(),
            "expiry_date" => $this->getExpiresDate()->format("m-Y"),
            "cvv_code" => $this->getCvvCode()
        );
    }


    /**
     * @param float $amount
     * @return CreditCardPayment
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
     * @return CreditCardPayment
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param Currency $currency
     * @return CreditCardPayment
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
     * @return CreditCardPayment
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
     * @param int $cvvCode
     * @return CreditCardPayment
     */
    public function setCvvCode($cvvCode)
    {
        $this->cvvCode = $cvvCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getCvvCode()
    {
        return $this->cvvCode;
    }

    /**
     * @param \DateTime $date
     * @return CreditCardPayment
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
     * @return CreditCardPayment
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
     * @return CreditCardPayment
     */
    public function setExpiresDate($expiresDate)
    {
        $this->expiresDate = $expiresDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresDate()
    {
        return $this->expiresDate;
    }

    /**
     * @param string $holdersName
     * @return CreditCardPayment
     */
    public function setHoldersName($holdersName)
    {
        $this->holdersName = $holdersName;

        return $this;
    }

    /**
     * @return string
     */
    public function getHoldersName()
    {
        return $this->holdersName;
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
     * @return CreditCardPayment
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
     * @return CreditCardPayment
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
     * @return CreditCardPayment
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
     * @return CreditCardPayment
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
     * @return CreditCardPayment
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
