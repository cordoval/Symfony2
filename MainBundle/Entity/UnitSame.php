<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\UnitSame
 *
 * @ORM\Table(name="unit_same")
 * @ORM\Entity
 */
class UnitSame
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", unique=true, length=255, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Unit", inversedBy="sameUnits")
     * @ORM\JoinTable(name="unit_same_units",
     *   joinColumns={
     *     @ORM\JoinColumn(name="unit_same_id", referencedColumnName="id", nullable=true)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="unit_id", referencedColumnName="id", nullable=true)
     *   }
     * )
     */
    private $units;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unit = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return UnitSame
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
     * Add unit
     *
     * @param PHRentals\MainBundle\Entity\Unit $unit
     * @return UnitSame
     */
    public function addUnit(\PHRentals\MainBundle\Entity\Unit $unit)
    {
        $this->units[] = $unit;
    
        return $this;
    }

    /**
     * Remove unit
     *
     * @param PHRentals\MainBundle\Entity\Unit $unit
     */
    public function removeUnit(\PHRentals\MainBundle\Entity\Unit $unit)
    {
        $this->units->removeElement($unit);
    }

    /**
     * Get units
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUnits()
    {
        return $this->units;
    }
    
    public function __toString()
    {
    	return $this->getName();
    }
}