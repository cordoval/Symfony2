<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PHRentals\MainBundle\Entity\Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="PHRentals\MainBundle\Repository\ContactRepository")
 * @UniqueEntity(fields={"ownerRef"}, message="Owner Reference is already used.")
 * @UniqueEntity(fields={"name"}, message="Contact name is already used.")
 */
class Contact
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
    */
    private $name;
    
    /**
     * @var string $ownerRef
     *
     * @ORM\Column(name="owner_ref", type="string", length=127, nullable=true, unique=true)
     */
    private $ownerRef;
    
    /**
     * @var string $oldOwnerRef
     *
     * @ORM\Column(name="old_owner_ref", type="string", length=127, nullable=true)
     */
    private $oldOwnerRef;
    

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="ContactType")
     * @ORM\JoinTable(name="contact_has_types",
     *   joinColumns={
     *     @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="contact_type_id", referencedColumnName="id")
     *   }
     * )
     */
    private $contactTypes;
	 
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ContactMarket")
     * @ORM\JoinTable(name="contact_has_markets",
     *   joinColumns={
     *     @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="contact_market_id", referencedColumnName="id")
     *   }
     * )
     */
    private $markets;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Project", mappedBy="developer", cascade={"all"}, orphanRemoval=false)
     */
    private $projects;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ContactDevType")
     * @ORM\JoinTable(name="contact_has_dev_types",
     *   joinColumns={
     *     @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="contact_dev_type_id", referencedColumnName="id")
     *   }
     * )
     */
    private $devTypes;
    
    /**
     * @var string $web
     *
     * @ORM\Column(name="web", type="string", length=255, nullable=true)
     */
    private $web;
    
    /**
     * @var ArrayCollection $emails
     *
     * @ORM\OneToMany(targetEntity="ContactEmail", mappedBy="contact", cascade={"all"}, orphanRemoval=true)
     */
    private $emails;
    
    /**
     * @var ArrayCollection $tels
     *
     * @ORM\OneToMany(targetEntity="ContactTel", mappedBy="contact", cascade={"all"}, orphanRemoval=true)
     */
    private $tels;
    
    /**
     * @var ArrayCollection $reps
     *
     * @ORM\OneToMany(targetEntity="ContactRepresentative", mappedBy="contact", cascade={"all"}, orphanRemoval=true)
     */
    private $reps;
    
    
    /**
     * @var string $source
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    //private $source;

    /**
     * @var string $responsive
     *
     * @ORM\Column(name="responsive", type="string", length=32, nullable=true)
     */
    private $responsive;
    
    public static function getResponsiveList()
    {
    	return array(
    			'very responsive' => 'very responsive',
    			'only email/phone' => 'only email/phone',
    			'only email' => 'only email',
    			'only call' => 'only call',
    			'not so responsive' => 'not so responsive',
    			'not responsive at all' => 'not responsive at all'
    	);
    }
    
    /**
     * @var string $validation
     *
     * @ORM\Column(name="validation", type="string", length=32, nullable=true)
     */
    private $validation = 'complete';
    
    public static function getValidationList()
    {
    	return array(
    			'incomplete' => ' incomplete',
    			'bad data' => 'bad data',
    			'complete' => 'complete',
    			'out of date' => 'out of date',
    	);
    }
    
    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="validatedByUser", referencedColumnName="id")
     * })
     */
    private $validatedByUser;
    
    
    /**
     * @var ArrayCollection $units
     *
     * @ORM\OneToMany(targetEntity="Unit", mappedBy="owner", cascade={"all"}, orphanRemoval=false)
     */
    private $units;
       
    /**
     * @var string $notes
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;
    
    /**
     * @var string $prefixName
     *
     * @ORM\Column(name="prefix_name", type="string", length=4, nullable=true)
     */
    private $prefixName;
    
    public static function getPrefixList()
    {
    	return array(
    			'Mr.' => 'Mr.',
    			'Mrs.' => 'Mrs.',
    			'Ms.' => 'Ms.'
    	);
    }
    
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
     * @var integer $age
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;
    
    /**
     * @var string $nationality
     *
     * @ORM\Column(name="nationality", type="string", length=255, nullable=true)
     */
    private $nationality;
    
    /**
     * @var string $addressHome
     *
     * @ORM\Column(name="address_home", type="text", nullable=true)
     */
    private $addressHome;
    
    /**
     * @var string $address
     *
     * @ORM\Column(name="address_thai", type="text", nullable=true)
     */
    private $address;
    
    /**
     * @var string $addrThaiStreet1
     *
     * @ORM\Column(name="addr_thai_street_1", type="string", length=255, nullable=true)
     */
    private $addrThaiStreet1;
    
    /**
     * @var string $addrThaiStreet2
     *
     * @ORM\Column(name="addr_thai_street_2", type="string", length=255, nullable=true)
     */
    private $addrThaiStreet2;
    
    /**
     * @var string $addrThaiStreet3
     *
     * @ORM\Column(name="addr_thai_street_3", type="string", length=255, nullable=true)
     */
    private $addrThaiStreet3;
    
    
    /**
     * @var string $addrThaiStreet4
     *
     * @ORM\Column(name="addr_thai_street_4", type="string", length=255, nullable=true)
     */
    private $addrThaiStreet4;
    
    
    /**
     * @var string $addrThaiStreet5
     *
     * @ORM\Column(name="addr_thai_street_5", type="string", length=255, nullable=true)
     */
    private $addrThaiStreet5;
    
    
    /**
     * @var string $addrThaiStreet6
     *
     * @ORM\Column(name="addr_thai_street_6", type="string", length=255, nullable=true)
     */
    private $addrThaiStreet6;
    
    /**
     * @var string $addrThaiCity
     *
     * @ORM\Column(name="addr_thai_city", type="string", length=255, nullable=true)
     */
    private $addrThaiCity;
    
    /**
     * @var string $addrThaiProvince
     *
     * @ORM\Column(name="addr_thai_province", type="string", length=255, nullable=true)
     */
    private $addrThaiProvince;
     
    /**
     * @var string $addrThaiZip
     *
     * @ORM\Column(name="addr_thai_zip", type="string", length=255, nullable=true)
     */
    private $addrThaiZip;
    
    /**
     * @var string $addrThaiCountry
     *
     * @ORM\Column(name="addr_thai_country", type="string", length=255, nullable=true)
     */
    private $addrThaiCountry = "Thailand";
    

       
    /**
     * @ORM\Column(name="createdOn", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdOn;
    
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
     * @ORM\Column(name="updatedOn", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedOn;
    
    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="updatedByUser", referencedColumnName="id")
     * })
     */
    private $updatedByUser;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->tels = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->reps = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->units = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->contactTypes = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->markets = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->devTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * To String
     */
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
     * @return Contact
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
     * Set ownerRef
     *
     * @param string $ownerRef
     * @return Contact
     */
    public function setOwnerRef($ownerRef)
    {
        $this->ownerRef = $ownerRef;
    
        return $this;
    }

    /**
     * Get ownerRef
     *
     * @return string 
     */
    public function getOwnerRef()
    {
        return $this->ownerRef;
    }

    /**
     * Set oldOwnerRef
     *
     * @param string $oldOwnerRef
     * @return Contact
     */
    public function setOldOwnerRef($oldOwnerRef)
    {
        $this->oldOwnerRef = $oldOwnerRef;
    
        return $this;
    }

    /**
     * Get oldOwnerRef
     *
     * @return string 
     */
    public function getOldOwnerRef()
    {
        return $this->oldOwnerRef;
    }

    /**
     * Set responsive
     *
     * @param string $responsive
     * @return Contact
     */
    public function setResponsive($responsive)
    {
        $this->responsive = $responsive;
    
        return $this;
    }

    /**
     * Get responsive
     *
     * @return string 
     */
    public function getResponsive()
    {
        return $this->responsive;
    }

    /**
     * Set validation
     *
     * @param string $validation
     * @return Contact
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    
        return $this;
    }

    /**
     * Get validation
     *
     * @return string 
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Contact
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
     * Set prefixName
     *
     * @param string $prefixName
     * @return Contact
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
     * Set firstName
     *
     * @param string $firstName
     * @return Contact
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
     * @return Contact
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
     * Set age
     *
     * @param integer $age
     * @return Contact
     */
    public function setAge($age)
    {
        $this->age = $age;
    
        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     * @return Contact
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
     * Set addressHome
     *
     * @param string $addressHome
     * @return Contact
     */
    public function setAddressHome($addressHome)
    {
        $this->addressHome = $addressHome;
    
        return $this;
    }

    /**
     * Get addressHome
     *
     * @return string 
     */
    public function getAddressHome()
    {
        return $this->addressHome;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Contact
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
    
    public function getFullAddress()
    {
    	$address = "";
    	$address .= ($this->addrThaiStreet1? $this->addrThaiStreet1." ":"");
    	$address .= ($this->addrThaiStreet2? "Moo ".$this->addrThaiStreet2.", ":"");
    	$address .= ($this->addrThaiStreet3? $this->addrThaiStreet3.", ":"");
    	$address .= ($this->addrThaiStreet4? "Soi ".$this->addrThaiStreet4.", ":"");
    	$address .= ($this->addrThaiStreet5? $this->addrThaiStreet5.", ":"");
    	$address .= ($this->addrThaiStreet6? $this->addrThaiStreet6.", ":"");
    	$address .= ($this->addrThaiCity? $this->addrThaiCity.", ":"");
    	$address .= ($this->addrThaiProvince? $this->addrThaiProvince.", ":"");
    	$address .= ($this->addrThaiZip? $this->addrThaiZip.", ":"");
    	$address .= ($this->addrThaiCountry? $this->addrThaiCountry:"");
    
    	return $address;
    }

    /**
     * Set addrThaiStreet1
     *
     * @param string $addrThaiStreet1
     * @return Contact
     */
    public function setAddrThaiStreet1($addrThaiStreet1)
    {
        $this->addrThaiStreet1 = $addrThaiStreet1;
    
        return $this;
    }

    /**
     * Get addrThaiStreet1
     *
     * @return string 
     */
    public function getAddrThaiStreet1()
    {
        return $this->addrThaiStreet1;
    }

    /**
     * Set addrThaiStreet2
     *
     * @param string $addrThaiStreet2
     * @return Contact
     */
    public function setAddrThaiStreet2($addrThaiStreet2)
    {
        $this->addrThaiStreet2 = $addrThaiStreet2;
    
        return $this;
    }

    /**
     * Get addrThaiStreet2
     *
     * @return string 
     */
    public function getAddrThaiStreet2()
    {
        return $this->addrThaiStreet2;
    }

    /**
     * Set addrThaiStreet3
     *
     * @param string $addrThaiStreet3
     * @return Contact
     */
    public function setAddrThaiStreet3($addrThaiStreet3)
    {
        $this->addrThaiStreet3 = $addrThaiStreet3;
    
        return $this;
    }

    /**
     * Get addrThaiStreet3
     *
     * @return string 
     */
    public function getAddrThaiStreet3()
    {
        return $this->addrThaiStreet3;
    }

    /**
     * Set addrThaiStreet4
     *
     * @param string $addrThaiStreet4
     * @return Contact
     */
    public function setAddrThaiStreet4($addrThaiStreet4)
    {
        $this->addrThaiStreet4 = $addrThaiStreet4;
    
        return $this;
    }

    /**
     * Get addrThaiStreet4
     *
     * @return string 
     */
    public function getAddrThaiStreet4()
    {
        return $this->addrThaiStreet4;
    }

    /**
     * Set addrThaiStreet5
     *
     * @param string $addrThaiStreet5
     * @return Contact
     */
    public function setAddrThaiStreet5($addrThaiStreet5)
    {
        $this->addrThaiStreet5 = $addrThaiStreet5;
    
        return $this;
    }

    /**
     * Get addrThaiStreet5
     *
     * @return string 
     */
    public function getAddrThaiStreet5()
    {
        return $this->addrThaiStreet5;
    }

    /**
     * Set addrThaiStreet6
     *
     * @param string $addrThaiStreet6
     * @return Contact
     */
    public function setAddrThaiStreet6($addrThaiStreet6)
    {
        $this->addrThaiStreet6 = $addrThaiStreet6;
    
        return $this;
    }

    /**
     * Get addrThaiStreet6
     *
     * @return string 
     */
    public function getAddrThaiStreet6()
    {
        return $this->addrThaiStreet6;
    }

    /**
     * Set addrThaiCity
     *
     * @param string $addrThaiCity
     * @return Contact
     */
    public function setAddrThaiCity($addrThaiCity)
    {
        $this->addrThaiCity = $addrThaiCity;
    
        return $this;
    }

    /**
     * Get addrThaiCity
     *
     * @return string 
     */
    public function getAddrThaiCity()
    {
        return $this->addrThaiCity;
    }

    /**
     * Set addrThaiProvince
     *
     * @param string $addrThaiProvince
     * @return Contact
     */
    public function setAddrThaiProvince($addrThaiProvince)
    {
        $this->addrThaiProvince = $addrThaiProvince;
    
        return $this;
    }

    /**
     * Get addrThaiProvince
     *
     * @return string 
     */
    public function getAddrThaiProvince()
    {
        return $this->addrThaiProvince;
    }

    /**
     * Set addrThaiZip
     *
     * @param string $addrThaiZip
     * @return Contact
     */
    public function setAddrThaiZip($addrThaiZip)
    {
        $this->addrThaiZip = $addrThaiZip;
    
        return $this;
    }

    /**
     * Get addrThaiZip
     *
     * @return string 
     */
    public function getAddrThaiZip()
    {
        return $this->addrThaiZip;
    }

    /**
     * Set addrThaiCountry
     *
     * @param string $addrThaiCountry
     * @return Contact
     */
    public function setAddrThaiCountry($addrThaiCountry)
    {
        $this->addrThaiCountry = $addrThaiCountry;
    
        return $this;
    }

    /**
     * Get addrThaiCountry
     *
     * @return string 
     */
    public function getAddrThaiCountry()
    {
        return $this->addrThaiCountry;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return Contact
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    
        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime 
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set updatedOn
     *
     * @param \DateTime $updatedOn
     * @return Contact
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
    
        return $this;
    }

    /**
     * Get updatedOn
     *
     * @return \DateTime 
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Add contactTypes
     *
     * @param PHRentals\MainBundle\Entity\ContactType $contactTypes
     * @return Contact
     */
    public function addContactType(\PHRentals\MainBundle\Entity\ContactType $contactTypes)
    {
        $this->contactTypes[] = $contactTypes;
    
        return $this;
    }

    /**
     * Remove contactTypes
     *
     * @param PHRentals\MainBundle\Entity\ContactType $contactTypes
     */
    public function removeContactType(\PHRentals\MainBundle\Entity\ContactType $contactTypes)
    {
        $this->contactTypes->removeElement($contactTypes);
    }

    /**
     * Get contactTypes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContactTypes()
    {
        return $this->contactTypes;
    }
    
    public function hasType($search)
    {
    	foreach($this->contactTypes as $type) {
    
    		if ($type->getName() == $search) return true;
    	}
    	return false;
    }

    /**
     * Set validatedByUser
     *
     * @param Application\Sonata\UserBundle\Entity\User $validatedByUser
     * @return Contact
     */
    public function setValidatedByUser(\Application\Sonata\UserBundle\Entity\User $validatedByUser = null)
    {
        $this->validatedByUser = $validatedByUser;
    
        return $this;
    }

    /**
     * Get validatedByUser
     *
     * @return Application\Sonata\UserBundle\Entity\User 
     */
    public function getValidatedByUser()
    {
        return $this->validatedByUser;
    }

    /**
     * Add emails
     *
     * @param PHRentals\MainBundle\Entity\ContactEmail $emails
     * @return Contact
     */
    public function addEmail(\PHRentals\MainBundle\Entity\ContactEmail $email)
    {
    	$found = false;
    	foreach($this->emails as $existing) {
    		if($existing->getEmail() == $email->getEmail()) {
    			$found = true;
    		}
    	}
    	if (!$found) {
        $this->emails[] = $email;
        $email->setContact($this);
    	}
        return $this;
    }
    
    public function addEmails(\PHRentals\MainBundle\Entity\ContactEmail $email)
    {
    	$this->emails[] = $email;
    	$email->setContact($this);
    
    	return $this;
    }

    /**
     * Remove emails
     *
     * @param PHRentals\MainBundle\Entity\ContactEmail $emails
     */
    public function removeEmail(\PHRentals\MainBundle\Entity\ContactEmail $email)
    {
        $this->emails->removeElement($email);
        $email->setContact(null);
    }

    /**
     * Get emails
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }
    
    public function getEmail()
    {
    	return $this->emails;
    }
    
    public function setEmails($emails)
    {
    	$this->emails = $emails;
    	return $this;
    }

    /**
     * Add tels
     *
     * @param PHRentals\MainBundle\Entity\ContactTel $tels
     * @return Contact
     */
    public function addTel(\PHRentals\MainBundle\Entity\ContactTel $tel)
    {
    	$found = false;
    	foreach($this->tels as $existing) {
    		if($existing->getTel() == $tel->getTel()) {
    			$found = true;
    		}
    	}
    	if (!$found) {
        $this->tels[] = $tel;
        $tel->setContact($this);
    	}
        return $this;
    }

    public function addTels(\PHRentals\MainBundle\Entity\ContactTel $tel)
    {
    	$this->tels[] = $tel;
    	$tel->setContact($this);
    
    	return $this;
    }
    
    /**
     * Remove tels
     *
     * @param PHRentals\MainBundle\Entity\ContactTel $tels
     */
    public function removeTel(\PHRentals\MainBundle\Entity\ContactTel $tels)
    {
        $this->tels->removeElement($tels);
        $tels->setContact(null);
    }

    /**
     * Get tels
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTels()
    {
        return $this->tels;
    }
    
    public function getTel()
    {
    	return $this->tels;
    }
    
    public function setTels($tels)
    {
    	$this->tels = $tels;
    	return $this;
    }
    

    /**
     * Add Reps
     *
     * @param PHRentals\MainBundle\Entity\ContactRepresentative $reps
     * @return Contact
     */
    
    public function addRep(\PHRentals\MainBundle\Entity\ContactRepresentative $reps)
    {
        $this->reps[] = $reps;
        $reps->setContact($this);
    
        return $this;
    }
    
    public function addReps(\PHRentals\MainBundle\Entity\ContactRepresentative $reps)
    {
    	$this->reps[] = $reps;
    	$reps->setContact($this);
    
    	return $this;
    }

    /**
     * Remove Reps
     *
     * @param PHRentals\MainBundle\Entity\ContactRep $reps
     */
    public function removeRep(\PHRentals\MainBundle\Entity\ContactRepresentative $reps)
    {
        $this->reps->removeElement($reps);
        $reps->setContact(null);
    }
    
    public function removeReps(\PHRentals\MainBundle\Entity\ContactRepresentative $reps)
    {
    	$this->reps->removeElement($reps);
    	$reps->setContact(null);
    }

    /**
     * Get Reps
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getReps()
    {
        return $this->reps;
    }
    
    public function getRep()
    {
    	return $this->reps;
    }
    
    public function setReps($reps)
    {
    	$this->reps = $reps;
    	return $this;
    }

    /**
     * Add units
     *
     * @param PHRentals\MainBundle\Entity\Unit $units
     * @return Contact
     */
    public function addUnit(\PHRentals\MainBundle\Entity\Unit $units)
    {
        $this->units[] = $units;
        $units->setOwner($this);
    
        return $this;
    }
    
    public function addUnits(\PHRentals\MainBundle\Entity\Unit $units)
    {
    	$this->units[] = $units;
    	$units->setOwner($this);
    
    	return $this;
    }

    /**
     * Remove units
     *
     * @param PHRentals\MainBundle\Entity\Unit $units
     */
    public function removeUnit(\PHRentals\MainBundle\Entity\Unit $units)
    {
        $this->units->removeElement($units);
        $units->setOwner(null);
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
    
    public function getUnit()
    {
    	return $this->units;
    }
    
    public function setUnits($units)
    {
    	$this->units = $units;
    	return $this;
    }

    /**
     * Set web
     *
     * @param string $web
     * @return Contact
     */
    public function setWeb($web)
    {
        $this->web = $web;
    
        return $this;
    }

    /**
     * Get web
     *
     * @return string 
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Add markets
     *
     * @param PHRentals\MainBundle\Entity\ContactMarket $markets
     * @return Contact
     */
    public function addMarket(\PHRentals\MainBundle\Entity\ContactMarket $markets)
    {
        $this->markets[] = $markets;
    
        return $this;
    }

    /**
     * Remove markets
     *
     * @param PHRentals\MainBundle\Entity\ContactMarket $markets
     */
    public function removeMarket(\PHRentals\MainBundle\Entity\ContactMarket $markets)
    {
        $this->markets->removeElement($markets);
    }

    /**
     * Get markets
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMarkets()
    {
        return $this->markets;
    }

    /**
     * Add projects
     *
     * @param PHRentals\MainBundle\Entity\Project $projects
     * @return Contact
     */
    public function addProject(\PHRentals\MainBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;
    
        return $this;
    }

    /**
     * Remove projects
     *
     * @param PHRentals\MainBundle\Entity\Project $projects
     */
    public function removeProject(\PHRentals\MainBundle\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add devTypes
     *
     * @param PHRentals\MainBundle\Entity\ContactDevType $devTypes
     * @return Contact
     */
    public function addDevType(\PHRentals\MainBundle\Entity\ContactDevType $devTypes)
    {
        $this->devTypes[] = $devTypes;
    
        return $this;
    }

    /**
     * Remove devTypes
     *
     * @param PHRentals\MainBundle\Entity\ContactDevType $devTypes
     */
    public function removeDevType(\PHRentals\MainBundle\Entity\ContactDevType $devTypes)
    {
        $this->devTypes->removeElement($devTypes);
    }

    /**
     * Get devTypes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDevTypes()
    {
        return $this->devTypes;
    }
    
    public function hasDevType($search)
    {
    	foreach($this->devTypes as $type) {
    
    		if ($type->getName() == $search) return true;
    	}
    	return false;
    }

    /**
     * Set createdByUser
     *
     * @param Application\Sonata\UserBundle\Entity\User $createdByUser
     * @return Contact
     */
    public function setCreatedByUser(\Application\Sonata\UserBundle\Entity\User $createdByUser = null)
    {
        $this->createdByUser = $createdByUser;
    
        return $this;
    }

    /**
     * Get createdByUser
     *
     * @return Application\Sonata\UserBundle\Entity\User 
     */
    public function getCreatedByUser()
    {
        return $this->createdByUser;
    }

    /**
     * Set updatedByUser
     *
     * @param Application\Sonata\UserBundle\Entity\User $updatedByUser
     * @return Contact
     */
    public function setUpdatedByUser(\Application\Sonata\UserBundle\Entity\User $updatedByUser = null)
    {
        $this->updatedByUser = $updatedByUser;
    
        return $this;
    }

    /**
     * Get updatedByUser
     *
     * @return Application\Sonata\UserBundle\Entity\User 
     */
    public function getUpdatedByUser()
    {
        return $this->updatedByUser;
    }
}