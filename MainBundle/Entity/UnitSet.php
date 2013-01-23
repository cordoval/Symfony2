<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\UnitSet
 *
 * @ORM\Table(name="unit_set")
 * @ORM\Entity
 */
class UnitSet
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
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="createdByUser", referencedColumnName="id")
     * })
     */
    private $createdByUser;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Unit", inversedBy="unitSet")
     * @ORM\JoinTable(name="unit_set_units",
     *   joinColumns={
     *     @ORM\JoinColumn(name="unit_set_id", referencedColumnName="id", nullable=true)
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
     * @return UnitSet
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
     * Set createdByUser
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return ReservationSet
     */
    public function setCreatedByUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->createdByUser = $user;
    
        return $this;
    }

    /**
     * Get createdByUser
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getCreatedByUser()
    {
        return $this->createdByUser;
    }

    /**
     * Add unit
     *
     * @param PHRentals\MainBundle\Entity\Unit $unit
     * @return UnitSet
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