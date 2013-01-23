<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\ContactRepresentative
 *
 * @ORM\Table(name="contact_representative")
 * @ORM\Entity
 */
class ContactRepresentative
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
     * @var string $note
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;
    
    /**
     * @var string $firstName
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;
    
    /**
     * @var string $lastName
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;
    
    /**
     * @var string $prefixName
     *
     * @ORM\Column(name="prefix_name", type="string", length=4, nullable=true)
     */
    private $prefixName;
    
    public static function getPrefixList()
    {
    	return array(
    			'' => '',
    			'Mr.' => 'Mr.',
    			'Mrs.' => 'Mrs.',
    			'Ms.' => 'Ms.'
    	);
    }
    
    /**
     * @var string $tel
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;
     
    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    
    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="reps")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * })
     */
    private $contact;
    
    public function __toString()
    {
    	return $this->getName();
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
     * @return ContactRepresentative
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
     * Set note
     *
     * @param string $note
     * @return ContactRepresentative
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return ContactRepresentative
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return ContactRepresentative
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set prefixName
     *
     * @param string $prefixName
     * @return ContactRepresentative
     */
    public function setPrefixName($prefixName)
    {
        $this->prefixName = $prefixName;
    
        return $this;
    }

    /**
     * Get prefixName
     *
     * @return string 
     */
    public function getPrefixName()
    {
        return $this->prefixName;
    }

    /**
     * Set contact
     *
     * @param PHRentals\MainBundle\Entity\Contact $contact
     * @return ContactRepresentative
     */
    public function setContact(\PHRentals\MainBundle\Entity\Contact $contact = null)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return PHRentals\MainBundle\Entity\Contact 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return ContactRepresentative
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    
        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ContactRepresentative
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
}