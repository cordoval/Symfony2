<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PHRentals\MainBundle\Entity\Tenant
 *
 * @ORM\Table(name="tenant")
 * @ORM\Entity
 */
class Tenant
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
     * @var string $firstName
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
    */
    private $firstName;
    
    /**
    * @var string $lastName
    *
    * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
    */
    private $lastName;
    
    /**
     * @var string $prefixName
     *
     * @ORM\Column(name="prefix_name", type="string", length=4, nullable=false)
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
	 * @var string $adrStreet1
	 *
	 * @ORM\Column(name="adr_thai_street_1", type="string", length=255, nullable=true)
	 */
	private $adrStreet1;
	
	/**
	 * @var string $adrStreet2
	 *
	 * @ORM\Column(name="adr_thai_street_2", type="string", length=255, nullable=true)
	 */
	private $adrStreet2;

	/**
	 * @var string $adrStreet3
	 *
	 * @ORM\Column(name="adr_thai_street_3", type="string", length=255, nullable=true)
	 */
	private $adrStreet3;
	

	/**
	 * @var string $adrStreet4
	 *
	 * @ORM\Column(name="adr_thai_street_4", type="string", length=255, nullable=true)
	 */
	private $adrStreet4;
	

	/**
	 * @var string $adrStreet5
	 *
	 * @ORM\Column(name="adr_thai_street_5", type="string", length=255, nullable=true)
	 */
	private $adrStreet5;
	

	/**
	 * @var string $adrStreet6
	 *
	 * @ORM\Column(name="adr_thai_street_6", type="string", length=255, nullable=true)
	 */
	private $adrStreet6;

	/**
	 * @var string $adrCity
	 *
	 * @ORM\Column(name="adr_thai_city", type="string", length=255, nullable=true)
	 */
	private $adrCity;
	
	/**
	 * @var string $adrProvince
	 *
	 * @ORM\Column(name="adr_thai_province", type="string", length=255, nullable=true)
	 */
	private $adrProvince;
	 
	/**
	 * @var string $adrZip
	 *
	 * @ORM\Column(name="adr_thai_zip", type="string", length=255, nullable=true)
	 */
	private $adrZip;
	
	/**
	 * @var string $adrCountry
	 *
	 * @ORM\Column(name="adr_thai_country", type="string", length=255, nullable=true)
	 */
	private $adrCountry = "Thailand";
	
	/**
	* @var string $notes
	*
	* @ORM\Column(name="notes", type="text", nullable=true)
	*/
    private $notes;
    
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Owner
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
     * @return Owner
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Owner
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    public function __toString()
    {
    	return $this->getFirstName().' '.$this->getLastName();
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Owner
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
     * @return Owner
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
     * Set tel
     *
     * @param string $tel
     * @return Owner
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
     * @return Owner
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
     * Set notes
     *
     * @param string $notes
     * @return Owner
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
     * Set age
     *
     * @param integer $age
     * @return Owner
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
     * @return Owner
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
     * Set prefixName
     *
     * @param string $prefixName
     * @return Owner
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
     * Set adrStreet1
     *
     * @param string $adrStreet1
     * @return Tenant
     */
    public function setAdrStreet1($adrStreet1)
    {
        $this->adrStreet1 = $adrStreet1;
    
        return $this;
    }

    /**
     * Get adrStreet1
     *
     * @return string 
     */
    public function getAdrStreet1()
    {
        return $this->adrStreet1;
    }

    /**
     * Set adrStreet2
     *
     * @param string $adrStreet2
     * @return Tenant
     */
    public function setAdrStreet2($adrStreet2)
    {
        $this->adrStreet2 = $adrStreet2;
    
        return $this;
    }

    /**
     * Get adrStreet2
     *
     * @return string 
     */
    public function getAdrStreet2()
    {
        return $this->adrStreet2;
    }

    /**
     * Set adrStreet3
     *
     * @param string $adrStreet3
     * @return Tenant
     */
    public function setAdrStreet3($adrStreet3)
    {
        $this->adrStreet3 = $adrStreet3;
    
        return $this;
    }

    /**
     * Get adrStreet3
     *
     * @return string 
     */
    public function getAdrStreet3()
    {
        return $this->adrStreet3;
    }

    /**
     * Set adrStreet4
     *
     * @param string $adrStreet4
     * @return Tenant
     */
    public function setAdrStreet4($adrStreet4)
    {
        $this->adrStreet4 = $adrStreet4;
    
        return $this;
    }

    /**
     * Get adrStreet4
     *
     * @return string 
     */
    public function getAdrStreet4()
    {
        return $this->adrStreet4;
    }

    /**
     * Set adrStreet5
     *
     * @param string $adrStreet5
     * @return Tenant
     */
    public function setAdrStreet5($adrStreet5)
    {
        $this->adrStreet5 = $adrStreet5;
    
        return $this;
    }

    /**
     * Get adrStreet5
     *
     * @return string 
     */
    public function getAdrStreet5()
    {
        return $this->adrStreet5;
    }

    /**
     * Set adrStreet6
     *
     * @param string $adrStreet6
     * @return Tenant
     */
    public function setAdrStreet6($adrStreet6)
    {
        $this->adrStreet6 = $adrStreet6;
    
        return $this;
    }

    /**
     * Get adrStreet6
     *
     * @return string 
     */
    public function getAdrStreet6()
    {
        return $this->adrStreet6;
    }

    /**
     * Set adrCity
     *
     * @param string $adrCity
     * @return Tenant
     */
    public function setAdrCity($adrCity)
    {
        $this->adrCity = $adrCity;
    
        return $this;
    }

    /**
     * Get adrCity
     *
     * @return string 
     */
    public function getAdrCity()
    {
        return $this->adrCity;
    }

    /**
     * Set adrProvince
     *
     * @param string $adrProvince
     * @return Tenant
     */
    public function setAdrProvince($adrProvince)
    {
        $this->adrProvince = $adrProvince;
    
        return $this;
    }

    /**
     * Get adrProvince
     *
     * @return string 
     */
    public function getAdrProvince()
    {
        return $this->adrProvince;
    }

    /**
     * Set adrZip
     *
     * @param string $adrZip
     * @return Tenant
     */
    public function setAdrZip($adrZip)
    {
        $this->adrZip = $adrZip;
    
        return $this;
    }

    /**
     * Get adrZip
     *
     * @return string 
     */
    public function getAdrZip()
    {
        return $this->adrZip;
    }

    /**
     * Set adrCountry
     *
     * @param string $adrCountry
     * @return Tenant
     */
    public function setAdrCountry($adrCountry)
    {
        $this->adrCountry = $adrCountry;
    
        return $this;
    }

    /**
     * Get adrCountry
     *
     * @return string 
     */
    public function getAdrCountry()
    {
        return $this->adrCountry;
    }
}