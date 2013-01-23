<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\UnitTag
 *
 * @ORM\Table(name="unit_tags")
 * @ORM\Entity
 */
class UnitTag
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
     * @ORM\Column(name="name", unique=true, type="string", length=255, nullable=false)
     */
    private $name;
    
    /**
     * @var string $position
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;
    
    /**
     * @var string $group
     *
     * @ORM\Column(name="grouping", type="integer", nullable=true)
     */
    private $group;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Unit", mappedBy="tags")
     * 
     */
    private $units;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->units = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return UnitTag
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
     * Set position
     *
     * @param integer $position
     * @return UnitTag
     */
    public function setPosition($position)
    {
    	$this->position = $position;
    
    	return $this;
    }
    
    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
    	return $this->position;
    }
    
    /**
     * Set group
     *
     * @param integer $group
     * @return UnitTag
     */
    public function setGroup($group)
    {
    	$this->group = $group;
    
    	return $this;
    }
    
    /**
     * Get group
     *
     * @return integer
     */
    public function getGroup()
    {
    	return $this->group;
    }

    /**
     * Add unit
     *
     * @param PHRentals\MainBundle\Entity\Unit $unit
     * @return UnitTag
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
     * Get unit
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