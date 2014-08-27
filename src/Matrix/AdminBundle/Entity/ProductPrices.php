<?php

namespace Matrix\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPrices
 *
 * @ORM\Table(name="product_prices", indexes={@ORM\Index(name="Ref_12", columns={"product"}), @ORM\Index(name="Ref_13", columns={"currency"})})
 * @ORM\Entity
 */
class ProductPrices
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
     * @var \Products
     *
     * @ORM\ManyToOne(targetEntity="Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product", referencedColumnName="id")
     * })
     */
    private $product;

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
     * @return ProductPrices
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
     * @return ProductPrices
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
     * Set product
     *
     * @param \Matrix\ServiceBundle\Entity\Products $product
     * @return ProductPrices
     */
    public function setProduct(\Matrix\ServiceBundle\Entity\Products $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Matrix\ServiceBundle\Entity\Products 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set currency
     *
     * @param \Matrix\ServiceBundle\Entity\Currency $currency
     * @return ProductPrices
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
}