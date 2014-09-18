<?php

namespace Matrix\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DispatchItem
 *
 * @ORM\Table(name="dispatch_item", indexes={@ORM\Index(name="Ref_44", columns={"dispatch"}), @ORM\Index(name="Ref_45", columns={"unit_detail"})})
 * @ORM\Entity
 */
class DispatchItem
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
     * @var integer
     *
     * @ORM\Column(name="item", type="integer", nullable=false)
     */
    private $item;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

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
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=15, scale=3, nullable=false)
     */
    private $price = '0.000';

    /**
     * @var Dispatches
     *
     * @ORM\ManyToOne(targetEntity="Dispatches")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dispatch", referencedColumnName="id")
     * })
     */
    private $dispatch;

    /**
     * @var UnitDetail
     *
     * @ORM\ManyToOne(targetEntity="UnitDetail")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_detail", referencedColumnName="id")
     * })
     */
    private $unitDetail;

    /**
     * converts DispatchItem to array
     * @return array
     */
    public function toArray(){
        return array(
            "id" => $this->getId(),
            "item" => $this->getItem(),
            "type" => $this->getType(),
            "version" => $this->getVersion(),
            "status" => $this->getStatus(),
            "dispatch" => $this->getDispatch()->getId(),
            "unit_detail" => $this->getUnitDetail()->getId(),
            "quantity" => $this->getQuantity(),
            "price" => $this->getPrice()
        );
    }

    /**
     * @param float $price
     * @return DispatchItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }




    /**
     * @param int $quantity
     * @return DispatchItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;

    }



    /**
     * @param UnitDetail $unitDetail
     *
     * @return DispatchItem
     */
    public function setUnitDetail($unitDetail)
    {
        $this->unitDetail = $unitDetail;

        return $this;
    }

    /**
     * @return UnitDetail
     */
    public function getUnitDetail()
    {
        return $this->unitDetail;
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
     * Set item
     *
     * @param integer $item
     * @return DispatchItem
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return integer
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return DispatchItem
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set version
     *
     * @param integer $version
     * @return DispatchItem
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
     * @return DispatchItem
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
     * Set order
     *
     * @param Dispatches $dispatch
     * @return DispatchItem
     */
    public function setDispatch(Dispatches $dispatch)
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    /**
     * Get order
     *
     * @return Dispatches
     */
    public function getDispatch()
    {
        return $this->dispatch;
    }
}
