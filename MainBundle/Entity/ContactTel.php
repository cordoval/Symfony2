<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\ContactTel
 *
 * @ORM\Table(name="contact_tel")
 * @ORM\Entity
 */
class ContactTel
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
     * @var string $tel
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=false)
     */
    private $tel;

    /**
     * @var string $note
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;
    
    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="tels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * })
     */
    private $contact;
    
    public function __toString()
    {
    	if($this->getTel()) {
    		return $this->getTel().($this->getNote() ? " (".$this->getNote().")" : "");
    	}
    	else {
    		return "";
    	}
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
     * Set tel
     *
     * @param string $tel
     * @return ContactTel
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
     * Set note
     *
     * @param string $note
     * @return ContactTel
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
     * Set contact
     *
     * @param PHRentals\MainBundle\Entity\Contact $contact
     * @return ContactTel
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
}