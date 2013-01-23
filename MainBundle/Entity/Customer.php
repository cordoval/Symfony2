<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="PHRentals\MainBundle\Repository\CustomerRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Customer
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string $nationality
     *
     * @ORM\Column(name="nationality", type="string", length=255, nullable=true)
     */
    private $nationality;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;

    /**
     * @var string $telephone1
     *
     * @ORM\Column(name="telephone1", type="string", length=255, nullable=true)
     */
    private $telephone1;

    /**
     * @var string $telephone2
     *
     * @ORM\Column(name="telephone2", type="string", length=255, nullable=true)
     */
    private $telephone2;

    /**
     * @var string $telephone3
     *
     * @ORM\Column(name="telephone3", type="string", length=255, nullable=true)
     */
    private $telephone3;

    /**
     * @var string $passport
     *
     * @ORM\Column(name="passport", type="string", length=255, nullable=true)
     */
    private $passport;

    /**
     * @var \DateTime $lastAction
     *
     * @ORM\Column(name="last_action", type="datetime", nullable=true)
     */
    private $lastAction;

    /**
     * @var string $notes
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = true;
    
    /**
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;
    
    /**
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lastAction = new \DateTime('now');
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
     * @return Customer
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
     * Set email
     *
     * @param string $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     * @return Customer
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    
        return $this;
    }

    /**
     * Get nationality
     *
     * @return string 
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set telephone1
     *
     * @param string $telephone1
     * @return Customer
     */
    public function setTelephone1($telephone1)
    {
        $this->telephone1 = $telephone1;
    
        return $this;
    }

    /**
     * Get telephone1
     *
     * @return string 
     */
    public function getTelephone1()
    {
        return $this->telephone1;
    }

    /**
     * Set telephone2
     *
     * @param string $telephone2
     * @return Customer
     */
    public function setTelephone2($telephone2)
    {
        $this->telephone2 = $telephone2;
    
        return $this;
    }

    /**
     * Get telephone2
     *
     * @return string 
     */
    public function getTelephone2()
    {
        return $this->telephone2;
    }

    /**
     * Set telephone3
     *
     * @param string $telephone3
     * @return Customer
     */
    public function setTelephone3($telephone3)
    {
        $this->telephone3 = $telephone3;
    
        return $this;
    }

    /**
     * Get telephone3
     *
     * @return string 
     */
    public function getTelephone3()
    {
        return $this->telephone3;
    }

    /**
     * Set passport
     *
     * @param string $passport
     * @return Customer
     */
    public function setPassport($passport)
    {
        $this->passport = $passport;
    
        return $this;
    }

    /**
     * Get passport
     *
     * @return string 
     */
    public function getPassport()
    {
        return $this->passport;
    }

    /**
     * Set lastAction
     *
     * @param \DateTime $lastAction
     * @return Customer
     */
    public function setLastAction($lastAction)
    {
        $this->lastAction = $lastAction;
    
        return $this;
    }

    /**
     * Get lastAction
     *
     * @return \DateTime 
     */
    public function getLastAction()
    {
        return $this->lastAction;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Customer
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Customer
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    
    
    public function getCreatedAt()
    {
    	return $this->createdAt;
    }
    
    public function getUpdatedAt()
    {
    	return $this->updatedAt;
    }
    
    public function __toString()
    {
    	return $this->getName();
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Customer
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    
        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Customer
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Customer
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }
    
}