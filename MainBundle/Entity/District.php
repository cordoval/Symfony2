<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\District
 *
 * @ORM\Table(name="district")
 * @ORM\Entity
 */
class District
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
     * @var string $factor
     *
     * @ORM\Column(name="factor", type="integer", nullable=false)
     */
    private $factor = 1;

    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;


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
     * @return District
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
    
    public function __toString()
    {
    	return $this->getName().' - '.$this->getLocation()->getName();
    }
    
    /**
     * Set factor
     *
     * @param integer $factor
     * @return District
     */
    public function setFactor($factor)
    {
    	$this->factor = $factor;
    
    	return $this;
    }
    
    /**
     * Get factor
     *
     * @return integer
     */
    public function getFactor()
    {
    	return $this->factor;
    }

    /**
     * Set location
     *
     * @param PHRentals\MainBundle\Entity\Location $location
     * @return District
     */
    public function setLocation(\PHRentals\MainBundle\Entity\Location $location = null)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return PHRentals\MainBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }
}