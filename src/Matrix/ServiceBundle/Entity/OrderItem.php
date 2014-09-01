<?php

namespace Matrix\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItem
 *
 * @ORM\Table(name="order_item", indexes={@ORM\Index(name="Ref_10", columns={"order"}),
 *                                          @ORM\Index(name="Ref_29", columns={"unit_detail"})})
 * @ORM\Entity(repositoryClass="Matrix\ServiceBundle\Repository\OrderItemRepository")
 */
class OrderItem
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
     * @var Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

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
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=15, scale=3, nullable=false)
     */
    private $price = 0;

    /**
     * converts OrderItem to array
     * @return array
     */
    public function toArray(){
        return array(
            "id" => $this->getId(),
            "item" => $this->getItem(),
            "type" => $this->getType(),
            "version" => $this->getVersion(),
            "status" => $this->getStatus(),
            "order" => $this->getOrder()->getId(),
            "unit_detail" => $this->getUnitDetail()->getId(),
            "quantity" => $this->getQuantity(),
            "price" => $this->getPrice()
        );
    }

    /**
     * @param float $price
     * @return OrderItem
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
     * @return OrderItem
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
     * @return OrderItem
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
     * @return OrderItem
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
     * @return OrderItem
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
     * @return OrderItem
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
     * @return OrderItem
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
     * @param \Matrix\ServiceBundle\Entity\Orders $order
     * @return OrderItem
     */
    public function setOrder(Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Matrix\ServiceBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
