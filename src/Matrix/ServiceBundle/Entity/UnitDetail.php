<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnitDetail
 *
 * @ORM\Table(name="unit_detail", indexes={@ORM\Index(name="Ref_22", columns={"unit"})})
 * @ORM\Entity(repositoryClass="Matrix\ServiceBundle\Repository\UnitDetailRepository")
 */
class UnitDetail
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
     * @ORM\Column(name="from", type="integer", nullable=false)
     */
    private $from;

    /**
     * @var integer
     *
     * @ORM\Column(name="to", type="integer", nullable=false)
     */
    private $to;

    /**
     * @var boolean
     *
     * @ORM\Column(name="main", type="boolean", nullable=false)
     */
    private $main = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer", nullable=false)
     */
    private $version = '1';

    /**
     * @var Unit
     *
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit", referencedColumnName="id")
     * })
     */
    private $unit;


    public function toArray(){
        return array(
            "id" => $this->getId(),
            "unit" => $this->getUnit()->getId(),
            "from" => $this->getFrom(),
            "to" => $this->getTo(),
            "name" => $this->getName(),
            "main" => ($this->getMain()) ? "1" : "0",
            "version" => $this->getVersion(),
            "status" => 1
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
     * @return UnitDetail
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
     * Set from
     *
     * @param integer $from
     * @return UnitDetail
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return integer 
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to
     *
     * @param integer $to
     * @return UnitDetail
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return integer 
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set main
     *
     * @param boolean $main
     * @return UnitDetail
     */
    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }

    /**
     * Get main
     *
     * @return boolean 
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * Set version
     *
     * @param integer $version
     * @return UnitDetail
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
     * Set unit
     *
     * @param \Matrix\ServiceBundle\Entity\Unit $unit
     * @return UnitDetail
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
}
