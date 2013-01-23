<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\AddressTag
 *
 * @ORM\Table(name="address_tags")
 * @ORM\Entity
 */
class AddressTag
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
     * @ORM\ManyToMany(targetEntity="Address", mappedBy="tags")
     * 
     */
    private $addresses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return AddressTag
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
     * Add address
     *
     * @param PHRentals\MainBundle\Entity\Address $address
     * @return AddressTag
     */
    public function addAddress(\PHRentals\MainBundle\Entity\Address $address)
    {
        $this->addresses[] = $address;
    
        return $this;
    }

    /**
     * Remove address
     *
     * @param PHRentals\MainBundle\Entity\Address $address
     */
    public function removeAddress(\PHRentals\MainBundle\Entity\Address $address)
    {
        $this->addresses->removeElement($address);
    }

    /**
     * Get address
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
    
    public function __toString()
    {
    	return $this->getName();
    }
    

    /**
     * Add addresses
     *
     * @param PHRentals\MainBundle\Entity\Address $addresses
     * @return Tag
     */
    public function addAddresse(\PHRentals\MainBundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;
    
        return $this;
    }

    /**
     * Remove addresses
     *
     * @param PHRentals\MainBundle\Entity\Address $addresses
     */
    public function removeAddresse(\PHRentals\MainBundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }
}