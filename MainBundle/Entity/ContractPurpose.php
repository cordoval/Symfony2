<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\ContractPurpose
 *
 * @ORM\Table(name="contract_purpose")
 * @ORM\Entity
 */
class ContractPurpose
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
     * @ORM\Column(name="name", type="string", unique=true, length=127, nullable=false)
     */
    private $name;

    /**
     * @var string $short
     *
     * @ORM\Column(name="short", type="string", unique=true, length=10, nullable=false)
     */
    private $short;
    
    
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
     * @return ContractPurpose
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
     * Set short
     *
     * @param string $short
     * @return ContractPurpose
     */
    public function setShort($short)
    {
    	$this->short = $short;
    
    	return $this;
    }
    
    /**
     * Get short
     *
     * @return string
     */
    public function getShort()
    {
    	return $this->short;
    }
    
    public function __toString()
    {
    	return $this->getName();
    }
}