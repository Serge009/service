<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServicePrices
 *
 * @ORM\Table(name="service_prices", indexes={@ORM\Index(name="Ref_14", columns={"currency"}), @ORM\Index(name="Ref_15", columns={"service"})})
 * @ORM\Entity
 */
class ServicePrices
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
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=9, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer", nullable=false)
     */
    private $version = '1';

    /**
     * @var \Currency
     *
     * @ORM\ManyToOne(targetEntity="Currency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency", referencedColumnName="id")
     * })
     */
    private $currency;

    /**
     * @var \Services
     *
     * @ORM\ManyToOne(targetEntity="Services")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service", referencedColumnName="id")
     * })
     */
    private $service;



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
     * Set price
     *
     * @param float $price
     * @return ServicePrices
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set version
     *
     * @param integer $version
     * @return ServicePrices
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
     * Set currency
     *
     * @param \Matrix\ServiceBundle\Entity\Currency $currency
     * @return ServicePrices
     */
    public function setCurrency(\Matrix\ServiceBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \Matrix\ServiceBundle\Entity\Currency 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set service
     *
     * @param \Matrix\ServiceBundle\Entity\Services $service
     * @return ServicePrices
     */
    public function setService(\Matrix\ServiceBundle\Entity\Services $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Matrix\ServiceBundle\Entity\Services 
     */
    public function getService()
    {
        return $this->service;
    }
}
