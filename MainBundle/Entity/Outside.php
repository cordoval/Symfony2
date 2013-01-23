<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PHRentals\MainBundle\Entity\Outside
 *
 * @ORM\Table(name="outside")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Outside
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
     */
    private $updatedOn;
    
    /**
     * @ORM\Column(name="validatedOn", type="datetime", nullable=true)
     */
    private $validatedOn;
    
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
     * @var string $name
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=false, unique=true)
     */
    private $link;
    
    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status;
    
    public static function getStatusList()
    {
    	return array(
    			'1/4 - listing link created' => '1/4 - listing link created',
    			'2/4 - owner updated listing' => '2/4 - owner updated listing',
    			'3/4 - owner submitted listing' => '3/4 - owner submitted listing',
    			'4/4 - listing imported' => '4/4 - listing imported',
    	);
    }
    
    /**
     * @var string $notes
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;
    
    
    //********************************
    //
    // CONTACT PART
    //
    //*********************************
    
    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Contact")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * })
     */
    private $contact;
    
    /**
     * @var string $ownerType
     *
     * @ORM\Column(name="owner_type", type="string", length=255, nullable=true)
     */
    private $ownerType;

    /**
     * @var string $name
     *
     * @ORM\Column(name="contact_name", type="string", length=255, nullable=true)
    */
    private $name;
    
    /**
     * @var string $web
     *
     * @ORM\Column(name="web", type="string", length=255, nullable=true)
     */
    private $web;
    
    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    
    /**
     * @var string $email2
     *
     * @ORM\Column(name="email2", type="string", length=255, nullable=true)
     */
    private $email2;
    
    /**
     * @var string $tel
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;
    
    /**
     * @var string $tel2
     *
     * @ORM\Column(name="tel2", type="string", length=255, nullable=true)
     */
    private $tel2;

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
     * @var boolean $sameAsUnitAddress
     *
     * @ORM\Column(name="same_unit_address", type="boolean", nullable=true)
     */
    private $sameAsUnitAddress;
    
    
    //*********************************
    //
    // UNIT PART
    //
    //*********************************
    
    /**
     * @var Unit
     *
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     * })
     */
    private $unit;
    
    /**
     * @var string $num
     *
     * @ORM\Column(name="num", type="string", length=255, nullable=true)
     */
    private $num;
    
    /**
     * @var UnitClass
     *
     * @ORM\ManyToOne(targetEntity="UnitClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_class_id", referencedColumnName="id")
     * })
     */
    private $class;
    
    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $project;
    
    /**
     * @var string $webTitle
     *
     * @ORM\Column(name="web_title", type="string", length=255, nullable=true)
     */
    private $webTitle;
    
    /**
     * @var string $ownership
     *
     * @ORM\Column(name="ownership", type="string", length=255, nullable=true)
     */
    private $ownership;
    
    public static function getOwnershipList()
    {
    	return array(
    			'Company' => 'Company',
    			'Foreign' =>'Foreign',
    			'Thai' =>'Thai',
    			'Thai/Company/Foreign' =>'Thai/Company/Foreign',
    			'Unknown' =>'Unknown'
    	);
    }
    
    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var integer $livingArea
     *
     * @ORM\Column(name="living_area", type="integer", nullable=true)
     */
    private $livingArea;
    
    /**
     * @var integer $landSize
     *
     * @ORM\Column(name="land_size", type="integer", nullable=true)
     */
    private $landSize;
    
    /**
     * @var UnitSize
     *
     * @ORM\ManyToOne(targetEntity="UnitSize")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_size_id", referencedColumnName="id")
     * })
     */
    private $unitType;
    
    /**
     * @var string $floor
     *
     * @ORM\Column(name="floor", type="string", nullable=true)
     */
    private $floor;
    
    /**
     * @var integer $bedrooms
     *
     * @ORM\Column(name="bedrooms", type="integer", nullable=true)
     */
    private $bedrooms;
    
    /**
     * @var integer $bathrooms
     *
     * @ORM\Column(name="bathrooms", type="integer", nullable=true)
     */
    private $bathrooms;
    
    /**
     * @var integer $sleeps
     *
     * @ORM\Column(name="sleeps", type="integer", nullable=true)
     */
    private $sleeps;
    
    /**
     * @var boolean $hasExtraBed
     *
     * @ORM\Column(name="extra_bed", type="boolean", nullable=true)
     */
    private $hasExtraBed;
    
    /**
     * @var string $remarks
     *
     * @ORM\Column(name="remarks", type="text", nullable=true)
     */
    private $remarks;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UnitTag")
     * @ORM\OrderBy({"id" = "ASC"})
     * @ORM\JoinTable(name="outside_has_unit_tags",
     *   joinColumns={
     *     @ORM\JoinColumn(name="outside_id", referencedColumnName="id", nullable=true)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=true)
     *   }
     * )
     */
    private $unit_tags;
    
    //*********************************
    //
    // ADDRESS PART
    //
    //*********************************
    
    /**
     * @var string $addressUnit
     *
     * @ORM\Column(name="address_text", type="text", length=255, nullable=true)
     */
    private $addressUnit;
    
    /**
     * @var District
     *
     * @ORM\ManyToOne(targetEntity="District")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     * })
     */
    private $district;
    
    /**
     * @var string $distanceToBeach
     *
     * @ORM\Column(name="distance_to_beach", type="string", length=255, nullable=true)
     */
    private $distanceToBeach;
    
    /**
     * @var string $unitsInBuilding
     *
     * @ORM\Column(name="unit_in_building", type="string", length=255, nullable=true)
     */
    private $unitsInBuilding;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AddressTag")
     * @ORM\JoinTable(name="outside_has_address_tags",
     *   joinColumns={
     *     @ORM\JoinColumn(name="outside_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *   }
     * )
     */
    private $address_tags;
    
    
    //*********************************
    //
    // CONTRACT PART
    //
    //*********************************
    
    /**
     * @var Contract
     *
     * @ORM\ManyToOne(targetEntity="Contract")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contract_id", referencedColumnName="id")
     * })
     */
    private $contract;
    
    /**
     * @var purposeSale
     *
     * @ORM\Column(name="purpose_sale", type="boolean", nullable=true)
     */
    private $purposeSale;
    
    /**
     * @var purposeRent
     *
     * @ORM\Column(name="purpose_rent", type="boolean", nullable=true)
     */
    private $purposeRent;
    
    /**
     * @var purposeRentHoliday
     *
     * @ORM\Column(name="purpose_holiday", type="boolean", nullable=true)
     */
    private $purposeRentHoliday;
    
    /**
     * @var string $agencyFee
     *
     * @ORM\Column(name="agency_fee", type="float", nullable=true)
     */
    private $agencyFee;
    
    /**
     * @var string $agencyDepositRate
     *
     * @ORM\Column(name="agency_deposit_fee", type="float", nullable=true)
     */
    private $agencyDepositRate;
    
    /**
     * @var string $commNote
     *
     * @ORM\Column(name="comm_note", type="text", nullable=true)
     */
    private $commNote;
    
    //*********************************
    //
    // CONTRACT UNIT PART
    //
    //*********************************
    
    /**
     * @var ContractUnit
     *
     * @ORM\ManyToOne(targetEntity="ContractUnit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contract_unit_id", referencedColumnName="id")
     * })
     */
    private $contract_unit;
    
    /**
     * @var string $incontract
     *
     * @ORM\Column(name="incontract", type="boolean")
     */
    private $incontract = true;
    
    /**
     * @var string $inspection
     *
     * @ORM\Column(name="inspection", type="text", nullable=true)
     */
    private $inspection;
    
    /**
     * @var string $keysAtLevel
     *
     * @ORM\Column(name="keys_at_level", type="string", length=255, nullable=true)
     */
    private $keysAtLevel;
    
    
    public static function getkeysAtLevelList()
    {
    	return array(
    			'at office' => 'at office',
    			'at reception' => 'at reception',
    			'with owner' => 'with owner',
    			'other'   => 'other',
    
    	);
    }
    
    /**
     * @var date $availableFrom
     *
     * @ORM\Column(name="available_from", type="datetime", nullable=true)
     */
    private $availableFrom;
    
    /**
     * @var date $dateFrom
     *
     * @ORM\Column(name="rented_date_from", type="datetime", nullable=true)
     */
    private $rentedDateFrom;
    
    /**
     * @var date $dateTo
     *
     * @ORM\Column(name="rented_date_to", type="datetime", nullable=true)
     */
    private $rentedDateTo;
    
    /**
     * @var string $note
     *
     * @ORM\Column(name="rented_note", type="string", nullable=true)
     */
    private $rentedNote;
    
    /**
     * @var integer $salePrice
     *
     * @ORM\Column(name="sale_price", type="integer", nullable=true)
     */
    private $salePrice;
    
    /**
     * @var boolean $negotiable
     *
     * @ORM\Column(name="negotiable", type="boolean", nullable=true)
     */
    private $negotiable;
    
    /**
     * @var string $transferFeeBy
     *
     * @ORM\Column(name="transfer_fee_by", type="string", nullable=true)
     */
    private $transferFeeBy;
    
    public static function getTransferFeeByList()
    {
    	return array(
    			'Owner' => '100% transfer fee included in sale price',
    			'Buyer' => 'Transfer fee to be fully paid by the Buyer',
    			'50/50 Owner and Buyer' => '50/50 Owner and Buyer',
    			'Negotiable' => 'Negotiable'
    	);
    }
    
    /**
     * @var string $deposit
     *
     * @ORM\Column(name="damage_deposit", type="string", nullable=true)
     */
    private $deposit;
    
    /**
     * @var integer $maxRepairCostPerMonth
     *
     * @ORM\Column(name="max_repair", type="integer", nullable=true)
     */
    private $maxRepairCostPerMonth;
    
    /**
     * @var string $dueDatePayment
     *
     * @ORM\Column(name="due_date_payment", type="string", nullable=true)
     */
    private $dueDatePayment;
    
    /**
     * @var integer $daysPayable
     *
     * @ORM\Column(name="days_payable", type="integer", nullable=true)
     */
    private $daysPayable;
    
    /**
     * @var integer $rentalDaily
     *
     * @ORM\Column(name="rental_daily", type="integer", nullable=true)
     */
    private $rentalDaily;
    
    /**
     * @var integer $rentalWeekly
     *
     * @ORM\Column(name="rental_weekly", type="integer", nullable=true)
     */
    private $rentalWeekly;
    
    /**
     * @var integer $rentalMonthly
     *
     * @ORM\Column(name="rental_monthly", type="integer", nullable=true)
     */
    private $rentalMonthly;
    
    /**
     * @var integer $rental3Month
     *
     * @ORM\Column(name="rental_3months", type="integer", nullable=true)
     */
    private $rental3Months;
    
    /**
     * @var integer $rental6Month
     *
     * @ORM\Column(name="rental_6months", type="integer", nullable=true)
     */
    private $rental6Months;
    
    /**
     * @var integer $rental1Year
     *
     * @ORM\Column(name="rental_1year", type="integer", nullable=true)
     */
    private $rental1Year;
    
    /**
     * @var string $highSeason
     *
     * @ORM\Column(name="high_season", type="float", nullable=false)
     */
    private $highSeason = '0';
    
    /**
     * @var string $peakSeason
     *
     * @ORM\Column(name="peak_season", type="float", nullable=false)
     */
    private $peakSeason = '0';
    
    /**
     * @var string $utilities
     *
     * @ORM\Column(name="utilities", type="text", nullable=true)
     */
    private $utilities;
    

    /**
     * @var string $conditions
     *
     * @ORM\Column(name="conditions", type="text", nullable=true)
     */
    private $conditions;
    
    /**
     * @var string $checkinTimes
     *
     * @ORM\Column(name="checkin_times", type="string", length=255, nullable=true)
     */
    private $checkinTimes = "14:00";
    
    /**
     * @var string $checkoutTimes
     *
     * @ORM\Column(name="checkout_times", type="string", length=255, nullable=true)
     */
    private $checkoutTimes = "10:00";
    
    /**
     * @var boolean $isOwnerCaretaker
     *
     * @ORM\Column(name="is_owner_care", type="boolean", nullable=true)
     */
    private $isOwnerCaretaker;
    
    /**
     * @var string $caretaker
     *
     * @ORM\Column(name="caretaker", type="string", length=255, nullable=true)
     */
    private $caretaker;
    
    /**
     * @var string $caretakerPhone
     *
     * @ORM\Column(name="caretaker_phone", type="string", length=255, nullable=true)
     */
    private $caretakerPhone;
    
    /**
     * @var string $caretakerEmail
     *
     * @ORM\Column(name="caretaker_email", type="string", length=255, nullable=true)
     */
    private $caretakerEmail;
    
    
    //*********************************
    //
    // LISTING DELETE
    //
    //*********************************
    
    /**
     * @var string $toDelete
     *
     * @ORM\Column(name="to_delete", type="string", length=255, nullable=true)
     */
    private $toDelete;
    
    /**
     * @var string $toDeleteText
     *
     * @ORM\Column(name="to_delete_text", type="text", nullable=true)
     */
    private $toDeleteText;  
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->unit_tags = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->address_tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	if ($this->getName())
    	return $this->getName();
    	else
    	return '';
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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return Outside
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
     * @return Outside
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
     * Set validatedOn
     *
     * @param \DateTime $validatedOn
     * @return Outside
     */
    public function setValidatedOn($validatedOn)
    {
    	$this->validatedOn = $validatedOn;
    
    	return $this;
    }
    
    /**
     * Get validatedOn
     *
     * @return \DateTime
     */
    public function getValidatedOn()
    {
    	return $this->validatedOn;
    }
    
    /**
     * Set ownerType
     *
     * @param string $ownerType
     * @return Outside
     */
    public function setOwnerType($ownerType)
    {
    	$this->ownerType = $ownerType;
    
    	return $this;
    }
    
    /**
     * Get ownerType
     *
     * @return string
     */
    public function getOwnerType()
    {
    	return $this->ownerType;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Outside
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
     * Set web
     *
     * @param string $web
     * @return Outside
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
     * Set email
     *
     * @param string $email
     * @return Outside
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
     * Set email2
     *
     * @param string $email2
     * @return Outside
     */
    public function setEmail2($email2)
    {
    	$this->email2 = $email2;
    
    	return $this;
    }
    
    /**
     * Get email2
     *
     * @return string
     */
    public function getEmail2()
    {
    	return $this->email2;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Outside
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
     * Set tel2
     *
     * @param string $tel
     * @return Outside
     */
    public function setTel2($tel)
    {
    	$this->tel2 = $tel;
    
    	return $this;
    }
    
    /**
     * Get tel2
     *
     * @return string
     */
    public function getTel2()
    {
    	return $this->tel2;
    }

    /**
     * Set prefixName
     *
     * @param string $prefixName
     * @return Outside
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
     * @return Outside
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
     * @return Outside
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
     * @return Outside
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
     * @return Outside
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
     * @return Outside
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
     * @return Outside
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
     * Set sameAsUnitAddress
     *
     * @param boolean $sameAsUnitAddress
     * @return Outside
     */
    public function setSameAsUnitAddress($sameAsUnitAddress)
    {
    	$this->sameAsUnitAddress = $sameAsUnitAddress;
    
    	return $this;
    }
    
    /**
     * Get sameAsUnitAddress
     *
     * @return boolean
     */
    public function getSameAsUnitAddress()
    {
    	return $this->sameAsUnitAddress;
    }

    /**
     * Set num
     *
     * @param string $num
     * @return Outside
     */
    public function setNum($num)
    {
        $this->num = $num;
    
        return $this;
    }

    /**
     * Get num
     *
     * @return string 
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set webTitle
     *
     * @param string $webTitle
     * @return Outside
     */
    public function setWebTitle($webTitle)
    {
        $this->webTitle = $webTitle;
    
        return $this;
    }

    /**
     * Get webTitle
     *
     * @return string 
     */
    public function getWebTitle()
    {
        return $this->webTitle;
    }

    /**
     * Set ownership
     *
     * @param string $ownership
     * @return Outside
     */
    public function setOwnership($ownership)
    {
        $this->ownership = $ownership;
    
        return $this;
    }

    /**
     * Get ownership
     *
     * @return string 
     */
    public function getOwnership()
    {
        return $this->ownership;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Outside
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set livingArea
     *
     * @param integer $livingArea
     * @return Outside
     */
    public function setLivingArea($livingArea)
    {
        $this->livingArea = $livingArea;
    
        return $this;
    }

    /**
     * Get livingArea
     *
     * @return integer 
     */
    public function getLivingArea()
    {
        return $this->livingArea;
    }

    /**
     * Set landSize
     *
     * @param integer $landSize
     * @return Outside
     */
    public function setLandSize($landSize)
    {
        $this->landSize = $landSize;
    
        return $this;
    }

    /**
     * Get landSize
     *
     * @return integer 
     */
    public function getLandSize()
    {
        return $this->landSize;
    }

    /**
     * Set floor
     *
     * @param string $floor
     * @return Outside
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;
    
        return $this;
    }

    /**
     * Get floor
     *
     * @return string 
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set bedrooms
     *
     * @param integer $bedrooms
     * @return Outside
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;
    
        return $this;
    }

    /**
     * Get bedrooms
     *
     * @return integer 
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * Set bathrooms
     *
     * @param integer $bathrooms
     * @return Outside
     */
    public function setBathrooms($bathrooms)
    {
        $this->bathrooms = $bathrooms;
    
        return $this;
    }

    /**
     * Get bathrooms
     *
     * @return integer 
     */
    public function getBathrooms()
    {
        return $this->bathrooms;
    }

    /**
     * Set sleeps
     *
     * @param integer $sleeps
     * @return Outside
     */
    public function setSleeps($sleeps)
    {
        $this->sleeps = $sleeps;
    
        return $this;
    }

    /**
     * Get sleeps
     *
     * @return integer 
     */
    public function getSleeps()
    {
        return $this->sleeps;
    }

    /**
     * Set hasExtraBed
     *
     * @param boolean $hasExtraBed
     * @return Outside
     */
    public function setHasExtraBed($hasExtraBed)
    {
        $this->hasExtraBed = $hasExtraBed;
    
        return $this;
    }

    /**
     * Get hasExtraBed
     *
     * @return boolean 
     */
    public function getHasExtraBed()
    {
        return $this->hasExtraBed;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return Outside
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    
        return $this;
    }

    /**
     * Get remarks
     *
     * @return string 
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set addressUnit
     *
     * @param string $addressUnit
     * @return Outside
     */
    public function setAddressUnit($addressUnit)
    {
        $this->addressUnit = $addressUnit;
    
        return $this;
    }

    /**
     * Get addressUnit
     *
     * @return string 
     */
    public function getAddressUnit()
    {
        return $this->addressUnit;
    }

    /**
     * Set distanceToBeach
     *
     * @param string $distanceToBeach
     * @return Outside
     */
    public function setDistanceToBeach($distanceToBeach)
    {
        $this->distanceToBeach = $distanceToBeach;
    
        return $this;
    }

    /**
     * Get distanceToBeach
     *
     * @return string 
     */
    public function getDistanceToBeach()
    {
        return $this->distanceToBeach;
    }

    /**
     * Set agencyFee
     *
     * @param float $agencyFee
     * @return Outside
     */
    public function setAgencyFee($agencyFee)
    {
        $this->agencyFee = $agencyFee;
    
        return $this;
    }

    /**
     * Get agencyFee
     *
     * @return float 
     */
    public function getAgencyFee()
    {
        return $this->agencyFee;
    }

    /**
     * Set agencyDepositRate
     *
     * @param float $agencyDepositRate
     * @return Outside
     */
    public function setAgencyDepositRate($agencyDepositRate)
    {
        $this->agencyDepositRate = $agencyDepositRate;
    
        return $this;
    }

    /**
     * Get agencyDepositRate
     *
     * @return float 
     */
    public function getAgencyDepositRate()
    {
        return $this->agencyDepositRate;
    }
    
    /**
     * Set incontract
     *
     * @param boolean $incontract
     * @return Outside
     */
    public function setIncontract($incontract)
    {
        $this->incontract = $incontract;
    
        return $this;
    }

    /**
     * Get incontract
     *
     * @return boolean 
     */
    public function getIncontract()
    {
        return $this->incontract;
    }
    
    /**
     * Set inspection
     *
     * @param string $inspection
     * @return Outside
     */
    public function setInspection($inspection)
    {
        $this->inspection = $inspection;
    
        return $this;
    }

    /**
     * Get inspection
     *
     * @return string 
     */
    public function getInspection()
    {
        return $this->inspection;
    }

    /**
     * Set keysAtLevel
     *
     * @param string $keysAtLevel
     * @return Outside
     */
    public function setKeysAtLevel($keysAtLevel)
    {
        $this->keysAtLevel = $keysAtLevel;
    
        return $this;
    }

    /**
     * Get keysAtLevel
     *
     * @return string 
     */
    public function getKeysAtLevel()
    {
        return $this->keysAtLevel;
    }

    /**
     * Set availableFrom
     *
     * @param \DateTime $availableFrom
     * @return Outside
     */
    public function setAvailableFrom($availableFrom)
    {
        $this->availableFrom = $availableFrom;
    
        return $this;
    }

    /**
     * Get availableFrom
     *
     * @return \DateTime 
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * Set salePrice
     *
     * @param integer $salePrice
     * @return Outside
     */
    public function setSalePrice($salePrice)
    {
        $this->salePrice = $salePrice;
    
        return $this;
    }

    /**
     * Get salePrice
     *
     * @return integer 
     */
    public function getSalePrice()
    {
        return $this->salePrice;
    }
    
    /**
     * Set negotiable
     *
     * @param boolean $negotiable
     * @return Outside
     */
    public function setNegotiable($negotiable)
    {
    	$this->negotiable = $negotiable;
    
    	return $this;
    }
    
    /**
     * Get negotiable
     *
     * @return boolean
     */
    public function getNegotiable()
    {
    	return $this->negotiable;
    }

    /**
     * Set transferFeeBy
     *
     * @param string $transferFeeBy
     * @return Outside
     */
    public function setTransferFeeBy($transferFeeBy)
    {
        $this->transferFeeBy = $transferFeeBy;
    
        return $this;
    }

    /**
     * Get transferFeeBy
     *
     * @return string 
     */
    public function getTransferFeeBy()
    {
        return $this->transferFeeBy;
    }
    
    /**
     * Set commNote
     *
     * @param string $commNote
     * @return Unit
     */
    public function setCommNote($remarks)
    {
    	$this->commNote = $remarks;
    
    	return $this;
    }
    
    /**
     * Get commNote
     *
     * @return string
     */
    public function getCommNote()
    {
    	return $this->commNote;
    }

    /**
     * Set deposit
     *
     * @param integer $deposit
     * @return Outside
     */
    public function setDeposit($deposit)
    {
        $this->deposit = $deposit;
    
        return $this;
    }

    /**
     * Get deposit
     *
     * @return integer 
     */
    public function getDeposit()
    {
        return $this->deposit;
    }

    /**
     * Set maxRepairCostPerMonth
     *
     * @param integer $maxRepairCostPerMonth
     * @return Outside
     */
    public function setMaxRepairCostPerMonth($maxRepairCostPerMonth)
    {
        $this->maxRepairCostPerMonth = $maxRepairCostPerMonth;
    
        return $this;
    }

    /**
     * Get maxRepairCostPerMonth
     *
     * @return integer 
     */
    public function getMaxRepairCostPerMonth()
    {
        return $this->maxRepairCostPerMonth;
    }

    /**
     * Set dueDatePayment
     *
     * @param string $dueDatePayment
     * @return Outside
     */
    public function setDueDatePayment($dueDatePayment)
    {
        $this->dueDatePayment = $dueDatePayment;
    
        return $this;
    }

    /**
     * Get dueDatePayment
     *
     * @return string 
     */
    public function getDueDatePayment()
    {
        return $this->dueDatePayment;
    }

    /**
     * Set daysPayable
     *
     * @param integer $daysPayable
     * @return Outside
     */
    public function setDaysPayable($daysPayable)
    {
        $this->daysPayable = $daysPayable;
    
        return $this;
    }

    /**
     * Get daysPayable
     *
     * @return integer 
     */
    public function getDaysPayable()
    {
        return $this->daysPayable;
    }
    
    /**
     * Set rentalDaily
     *
     * @param integer $rentalDaily
     * @return Outside
     */
    public function setRentalDaily($rentalDaily)
    {
    	$this->rentalDaily = $rentalDaily;
    
    	return $this;
    }
    
    /**
     * Get rentalDaily
     *
     * @return integer
     */
    public function getRentalDaily()
    {
    	return $this->rentalDaily;
    }

    /**
     * Set rentalWeekly
     *
     * @param integer $rentalWeekly
     * @return Outside
     */
    public function setRentalWeekly($rentalWeekly)
    {
        $this->rentalWeekly = $rentalWeekly;
    
        return $this;
    }

    /**
     * Get rentalWeekly
     *
     * @return integer 
     */
    public function getRentalWeekly()
    {
        return $this->rentalWeekly;
    }

    /**
     * Set rentalMonthly
     *
     * @param integer $rentalMonthly
     * @return Outside
     */
    public function setRentalMonthly($rentalMonthly)
    {
        $this->rentalMonthly = $rentalMonthly;
    
        return $this;
    }

    /**
     * Get rentalMonthly
     *
     * @return integer 
     */
    public function getRentalMonthly()
    {
        return $this->rentalMonthly;
    }

    /**
     * Set rental3Months
     *
     * @param integer $rental3Months
     * @return Outside
     */
    public function setRental3Months($rental3Months)
    {
        $this->rental3Months = $rental3Months;
    
        return $this;
    }

    /**
     * Get rental3Months
     *
     * @return integer 
     */
    public function getRental3Months()
    {
        return $this->rental3Months;
    }

    /**
     * Set rental6Months
     *
     * @param integer $rental6Months
     * @return Outside
     */
    public function setRental6Months($rental6Months)
    {
        $this->rental6Months = $rental6Months;
    
        return $this;
    }

    /**
     * Get rental6Months
     *
     * @return integer 
     */
    public function getRental6Months()
    {
        return $this->rental6Months;
    }

    /**
     * Set rental1Year
     *
     * @param integer $rental1Year
     * @return Outside
     */
    public function setRental1Year($rental1Year)
    {
        $this->rental1Year = $rental1Year;
    
        return $this;
    }

    /**
     * Get rental1Year
     *
     * @return integer 
     */
    public function getRental1Year()
    {
        return $this->rental1Year;
    }
    
    /**
     * Set highSeason
     *
     * @param float $highSeason
     * @return ContractUnit
     */
    public function setHighSeason($highSeason)
    {
    	$this->highSeason = $highSeason;
    
    	return $this;
    }
    
    /**
     * Get highSeason
     *
     * @return float
     */
    public function getHighSeason()
    {
    	return $this->highSeason;
    }
    
    /**
     * Set peakSeason
     *
     * @param float $peakSeason
     * @return ContractUnit
     */
    public function setPeakSeason($peakSeason)
    {
    	$this->peakSeason = $peakSeason;
    
    	return $this;
    }
    
    /**
     * Get peakSeason
     *
     * @return float
     */
    public function getPeakSeason()
    {
    	return $this->peakSeason;
    }

    /**
     * Set utilities
     *
     * @param integer $utilities
     * @return Outside
     */
    public function setUtilities($utilities)
    {
        $this->utilities = $utilities;
    
        return $this;
    }

    /**
     * Get utilities
     *
     * @return integer 
     */
    public function getUtilities()
    {
        return $this->utilities;
    }

    /**
     * Set conditions
     *
     * @param integer $conditions
     * @return Outside
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    
        return $this;
    }

    /**
     * Get conditions
     *
     * @return integer 
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set checkinTimes
     *
     * @param string $checkinTimes
     * @return Outside
     */
    public function setCheckinTimes($checkinTimes)
    {
        $this->checkinTimes = $checkinTimes;
    
        return $this;
    }

    /**
     * Get checkinTimes
     *
     * @return string 
     */
    public function getCheckinTimes()
    {
        return $this->checkinTimes;
    }

    /**
     * Set checkoutTimes
     *
     * @param string $checkoutTimes
     * @return Outside
     */
    public function setCheckoutTimes($checkoutTimes)
    {
        $this->checkoutTimes = $checkoutTimes;
    
        return $this;
    }

    /**
     * Get checkoutTimes
     *
     * @return string 
     */
    public function getCheckoutTimes()
    {
        return $this->checkoutTimes;
    }

    /**
     * Set isOwnerCaretaker
     *
     * @param boolean $isOwnerCaretaker
     * @return Outside
     */
    public function setIsOwnerCaretaker($isOwnerCaretaker)
    {
        $this->isOwnerCaretaker = $isOwnerCaretaker;
    
        return $this;
    }

    /**
     * Get isOwnerCaretaker
     *
     * @return boolean 
     */
    public function getIsOwnerCaretaker()
    {
        return $this->isOwnerCaretaker;
    }

    /**
     * Set caretaker
     *
     * @param string $caretaker
     * @return Outside
     */
    public function setCaretaker($caretaker)
    {
        $this->caretaker = $caretaker;
    
        return $this;
    }

    /**
     * Get caretaker
     *
     * @return string 
     */
    public function getCaretaker()
    {
        return $this->caretaker;
    }

    /**
     * Set caretakerPhone
     *
     * @param string $caretakerPhone
     * @return Outside
     */
    public function setCaretakerPhone($caretakerPhone)
    {
        $this->caretakerPhone = $caretakerPhone;
    
        return $this;
    }

    /**
     * Get caretakerPhone
     *
     * @return string 
     */
    public function getCaretakerPhone()
    {
        return $this->caretakerPhone;
    }

    /**
     * Set caretakerEmail
     *
     * @param string $caretakerEmail
     * @return Outside
     */
    public function setCaretakerEmail($caretakerEmail)
    {
        $this->caretakerEmail = $caretakerEmail;
    
        return $this;
    }

    /**
     * Get caretakerEmail
     *
     * @return string 
     */
    public function getCaretakerEmail()
    {
        return $this->caretakerEmail;
    }

    /**
     * Set createdByUser
     *
     * @param Application\Sonata\UserBundle\Entity\User $createdByUser
     * @return Outside
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
     * Set validatedByUser
     *
     * @param Application\Sonata\UserBundle\Entity\User $validatedByUser
     * @return Outside
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
     * Set contact
     *
     * @param PHRentals\MainBundle\Entity\Contact $contact
     * @return Outside
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
     * Set unit
     *
     * @param PHRentals\MainBundle\Entity\Unit $unit
     * @return Outside
     */
    public function setUnit(\PHRentals\MainBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return PHRentals\MainBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set class
     *
     * @param PHRentals\MainBundle\Entity\UnitClass $class
     * @return Outside
     */
    public function setClass(\PHRentals\MainBundle\Entity\UnitClass $class = null)
    {
        $this->class = $class;
    
        return $this;
    }

    /**
     * Get class
     *
     * @return PHRentals\MainBundle\Entity\UnitClass 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set project
     *
     * @param PHRentals\MainBundle\Entity\Project $project
     * @return Outside
     */
    public function setProject(\PHRentals\MainBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return PHRentals\MainBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set unitType
     *
     * @param PHRentals\MainBundle\Entity\UnitSize $unitType
     * @return Outside
     */
    public function setUnitType(\PHRentals\MainBundle\Entity\UnitSize $unitType = null)
    {
        $this->unitType = $unitType;
    
        return $this;
    }

    /**
     * Get unitType
     *
     * @return PHRentals\MainBundle\Entity\UnitSize 
     */
    public function getUnitType()
    {
        return $this->unitType;
    }

    /**
     * Add unit_tags
     *
     * @param PHRentals\MainBundle\Entity\UnitTag $unitTags
     * @return Outside
     */
    public function addUnitTag(\PHRentals\MainBundle\Entity\UnitTag $unitTags)
    {
        $this->unit_tags[] = $unitTags;
    
        return $this;
    }

    /**
     * Remove unit_tags
     *
     * @param PHRentals\MainBundle\Entity\UnitTag $unitTags
     */
    public function removeUnitTag(\PHRentals\MainBundle\Entity\UnitTag $unitTags)
    {
        $this->unit_tags->removeElement($unitTags);
    }

    /**
     * Get unit_tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUnitTags()
    {
        return $this->unit_tags;
    }
    
    public function setUnitTags($unit_tags)
    {
    	$this->unit_tags = $unit_tags;
    	return $this;
    }

    /**
     * Set district
     *
     * @param PHRentals\MainBundle\Entity\District $district
     * @return Outside
     */
    public function setDistrict(\PHRentals\MainBundle\Entity\District $district = null)
    {
        $this->district = $district;
    
        return $this;
    }

    /**
     * Get district
     *
     * @return PHRentals\MainBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Add address_tags
     *
     * @param PHRentals\MainBundle\Entity\AddressTag $addressTags
     * @return Outside
     */
    public function addAddressTag(\PHRentals\MainBundle\Entity\AddressTag $addressTags)
    {
        $this->address_tags[] = $addressTags;
    
        return $this;
    }

    /**
     * Remove address_tags
     *
     * @param PHRentals\MainBundle\Entity\AddressTag $addressTags
     */
    public function removeAddressTag(\PHRentals\MainBundle\Entity\AddressTag $addressTags)
    {
        $this->address_tags->removeElement($addressTags);
    }

    /**
     * Get address_tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAddressTags()
    {
        return $this->address_tags;
    }
    
    public function setAddressTags($address_tags)
    {
    	$this->address_tags = $address_tags;
    	return $this;
    }

    /**
     * Set contract
     *
     * @param PHRentals\MainBundle\Entity\Contract $contract
     * @return Outside
     */
    public function setContract(\PHRentals\MainBundle\Entity\Contract $contract = null)
    {
        $this->contract = $contract;
    
        return $this;
    }

    /**
     * Get contract
     *
     * @return PHRentals\MainBundle\Entity\Contract 
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Set purposeSale
     *
     * @param boolean $purposeSale
     * @return Outside
     */
    public function setPurposeSale($purposeSale)
    {
        $this->purposeSale = $purposeSale;
    
        return $this;
    }

    /**
     * Get purposeSale
     *
     * @return boolean 
     */
    public function getPurposeSale()
    {
        return $this->purposeSale;
    }
    
    /**
     * Set purposeRent
     *
     * @param boolean $purposeRent
     * @return Outside
     */
    public function setPurposeRent($purposeRent)
    {
    	$this->purposeRent = $purposeRent;
    
    	return $this;
    }
    
    /**
     * Get purposeRent
     *
     * @return boolean
     */
    public function getPurposeRent()
    {
    	return $this->purposeRent;
    }
    
    /**
     * Set purposeRentHoliday
     *
     * @param boolean $purposeRentHoliday
     * @return Outside
     */
    public function setPurposeRentHoliday($purposeRentHoliday)
    {
    	$this->purposeRentHoliday = $purposeRentHoliday;
    
    	return $this;
    }
    
    /**
     * Get purposeRentHoliday
     *
     * @return boolean
     */
    public function getPurposeRentHoliday()
    {
    	return $this->purposeRentHoliday;
    }

    /**
     * Set contract_unit
     *
     * @param PHRentals\MainBundle\Entity\ContractUnit $contractUnit
     * @return Outside
     */
    public function setContractUnit(\PHRentals\MainBundle\Entity\ContractUnit $contractUnit = null)
    {
        $this->contract_unit = $contractUnit;
    
        return $this;
    }

    /**
     * Get contract_unit
     *
     * @return PHRentals\MainBundle\Entity\ContractUnit 
     */
    public function getContractUnit()
    {
        return $this->contract_unit;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Outside
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Outside
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
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
     * Set unitsInBuilding
     *
     * @param string $unitsInBuilding
     * @return Outside
     */
    public function setUnitsInBuilding($unitsInBuilding)
    {
        $this->unitsInBuilding = $unitsInBuilding;
    
        return $this;
    }

    /**
     * Get unitsInBuilding
     *
     * @return string 
     */
    public function getUnitsInBuilding()
    {
        return $this->unitsInBuilding;
    }

    /**
     * Set rentedDateFrom
     *
     * @param \DateTime $rentedDateFrom
     * @return Outside
     */
    public function setRentedDateFrom($rentedDateFrom)
    {
        $this->rentedDateFrom = $rentedDateFrom;
    
        return $this;
    }

    /**
     * Get rentedDateFrom
     *
     * @return \DateTime 
     */
    public function getRentedDateFrom()
    {
        return $this->rentedDateFrom;
    }

    /**
     * Set rentedDateTo
     *
     * @param \DateTime $rentedDateTo
     * @return Outside
     */
    public function setRentedDateTo($rentedDateTo)
    {
        $this->rentedDateTo = $rentedDateTo;
    
        return $this;
    }

    /**
     * Get rentedDateTo
     *
     * @return \DateTime 
     */
    public function getRentedDateTo()
    {
        return $this->rentedDateTo;
    }

    /**
     * Set rentedNote
     *
     * @param string $rentedNote
     * @return Outside
     */
    public function setRentedNote($rentedNote)
    {
        $this->rentedNote = $rentedNote;
    
        return $this;
    }

    /**
     * Get rentedNote
     *
     * @return string 
     */
    public function getRentedNote()
    {
        return $this->rentedNote;
    }

    /**
     * Set toDelete
     *
     * @param string $toDelete
     * @return Outside
     */
    public function setToDelete($toDelete)
    {
        $this->toDelete = $toDelete;
    
        return $this;
    }

    /**
     * Get toDelete
     *
     * @return string 
     */
    public function getToDelete()
    {
        return $this->toDelete;
    }

    /**
     * Set toDeleteText
     *
     * @param string $toDeleteText
     * @return Outside
     */
    public function setToDeleteText($toDeleteText)
    {
        $this->toDeleteText = $toDeleteText;
    
        return $this;
    }

    /**
     * Get toDeleteText
     *
     * @return string 
     */
    public function getToDeleteText()
    {
        return $this->toDeleteText;
    }
    
}