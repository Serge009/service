<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products", indexes={@ORM\Index(name="Ref_21", columns={"unit"}), @ORM\Index(name="Ref_24", columns={"company"})})
 * @ORM\Entity(repositoryClass="Matrix\ServiceBundle\Repository\ProductsRepository")
 */
class Products
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=50, nullable=false)
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="vat", type="integer", nullable=false)
     */
    private $vat = '0';

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
     * @var Unit
     *
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit", referencedColumnName="id")
     * })
     */
    private $unit;

    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="company", referencedColumnName="id")
     * })
     */
    private $company;


    /**
     * converts Products to array
     * @return array
     */
    public function toArray(){
        return array(
            "id" => $this->getId(),
            "name" => $this->getName(),
            "version" => $this->getVersion(),
            "status" => $this->getStatus(),
            "unit" => $this->getUnit()->getId(),
            "vat" => $this->getVat(),
            "description" => $this->getDescription(),
            "quantity" => $this->getQuantity(),
            "code" => $this->getCode()
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
     * Set name
     *
     * @param string $name
     * @return Products
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

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Products
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Products
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Products
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set vat
     *
     * @param integer $vat
     * @return Products
     */
    public function setVat($vat)
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * Get vat
     *
     * @return integer 
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set version
     *
     * @param integer $version
     * @return Products
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
     * @return Products
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
     * Set unit
     *
     * @param \Matrix\ServiceBundle\Entity\Unit $unit
     * @return Products
     */
    public function setUnit(\Matrix\ServiceBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return \Matrix\ServiceBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set company
     *
     * @param \Matrix\ServiceBundle\Entity\Company $company
     * @return Products
     */
    public function setCompany(\Matrix\ServiceBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Matrix\ServiceBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }
}
