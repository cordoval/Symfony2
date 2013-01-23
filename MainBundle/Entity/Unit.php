<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * PHRentals\MainBundle\Entity\Unit
 *
 * @ORM\Table(name="unit")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="PHRentals\MainBundle\Repository\UnitRepository")
 * @UniqueEntity(fields={"pRef"}, message="Property Reference is already used.")
 * @ORM\HasLifecycleCallbacks 
 */
class Unit
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
     * @var string $pRef
     *
     * @ORM\Column(name="ref_id", type="string", length=127, nullable=false, unique=true)
     */
    private $pRef;
    
    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=127, nullable=false, unique=true)
     */
    private $slug;

    /**
     * @var string $num
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $num;
    

    /**
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="units")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * })
     */
    private $owner;
    
    /**
     * @var AddressClass
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="units")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $project;
    
    /**
     * @var Address
     *
     * @ORM\ManyToOne(targetEntity="Address", inversedBy="units")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $address;
    
    /**
     * @var string building
     *
     * @ORM\Column(name="building", type="string", length=255, nullable=true)
     */
    private $building;
    
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
     * @var string $propertyStatus
     *
     * @ORM\Column(name="property_status", type="string", length=63, nullable=true)
     */
    private $propertyStatus;
    
    public static function getPropertyStatusList()
    {
    	return array(
    			'Ready' => 'Ready',
    			'Off-plan' => 'Off-plan',
    			'Under construction/renovation' => 'Under construction/renovation'
    	);
    }
    
    /**
     * @var date $completedOn
     *
     * @ORM\Column(name="completed_on", type="datetime", nullable=true)
     */
    private $completedOn;
    
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
     * @ORM\ManyToMany(targetEntity="UnitTag", inversedBy="units")
     * @ORM\OrderBy({"id" = "ASC"})
     * @ORM\JoinTable(name="unit_has_unit_tags",
     *   joinColumns={
     *     @ORM\JoinColumn(name="unit_id", referencedColumnName="id", nullable=true)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=true)
     *   }
     * )
     */
    private $tags;
    
    /**
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = false;
    
    /**
     * @var boolean $generateThumbnails
     *
     * @ORM\Column(name="thumbnails", type="boolean", nullable=false)
     */
    private $generateThumbnails = false;
    
    /**
     * @var boolean $featured
     *
     * @ORM\Column(name="featured", type="boolean", nullable=false)
     */
    private $featured = false;
    
    /**
     * @var string $rating
     *
     * @ORM\Column(name="rating", type="string", length=63, nullable=true)
     */
    private $rating;
    
    /**
     * @var boolean $incomplete
     *
     * @ORM\Column(name="incomplete", type="boolean", nullable=false)
     */
    private $incomplete = false;
    
    /**
     * @var boolean $photos
     *
     * @ORM\Column(name="photos", type="boolean", nullable=false)
     */
    private $photos = false;
    
    /**
     * @var boolean $chanote
     *
     * @ORM\Column(name="chanote", type="boolean", nullable=false)
     */
    private $chanote = false;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="UnitImage", mappedBy="unit", orphanRemoval=true, cascade={"persist", "remove"})
     */
    protected $images;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ContractUnit", mappedBy="unit")
     */
    private $contracts;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Outside", mappedBy="unit")
     */
    private $outsides;
    
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UnitSet", mappedBy="units")
     */
    private $unitSet;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UnitSame", mappedBy="units")
     */
    private $sameUnits;
    
    /**
     * @var ArrayCollection $reservations
     *
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="unit")
     */
    private $reservations;
    
    /**
     * Get reservations
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
    	return $this->reservations;
    }
    
    /**
     * Get futureReservations
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFutureReservations()
    {
    	$resas = array();
        	foreach ($this->reservations as $reservation) {
    		if ($reservation->getDateTo()->format('Y-m-d') >= date('Y-m-d')) {
    			$resas[] = $reservation;
    		} 
    	}
    	
    	return $resas;
    }
    
    /**
     * @ORM\Column(name="createdOn", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdOn;
    
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
     *   @ORM\JoinColumn(name="createdByUser", referencedColumnName="id")
     * })
     */
    private $createdByUser;
    
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
        $this->unitSet = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sameUnits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contracts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->outsides = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->getPRef();
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
     * Set pRef
     *
     * @param string $pRef
     * @return Unit
     */
    public function setPRef($pRef)
    {
        $this->pRef = $pRef;
    
        return $this;
    }

    /**
     * Get pRef
     *
     * @return string 
     */
    public function getPRef()
    {
        return $this->pRef;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     * @return Unit
     */
    public function setSlug($slug)
    {
    	$this->slug = $slug;
    
    	return $this;
    }
    
    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
    	return $this->slug;
    }

    /**
     * Set num
     *
     * @param string $num
     * @return Unit
     */
    public function setNum($name)
    {
        $this->num = $name;
    
        return $this;
    }

    /**
     * Get building
     *
     * @return string 
     */
    public function getBuilding()
    {
        return $this->building;
    }
    
    /**
     * Set building
     *
     * @param string $building
     * @return Unit
     */
    public function setBuilding($building)
    {
    	$this->building = $building;
    
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
     * @return Unit
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
     * Set description
     *
     * @param string $description
     * @return Unit
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
     * Set rating
     *
     * @param string $rating
     * @return Unit
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    
        return $this;
    }

    /**
     * Get rating
     *
     * @return string 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set propertyStatus
     *
     * @param string $propertyStatus
     * @return Unit
     */
    public function setPropertyStatus($propertyStatus)
    {
        $this->propertyStatus = $propertyStatus;
    
        return $this;
    }

    /**
     * Get propertyStatus
     *
     * @return string 
     */
    public function getPropertyStatus()
    {
        return $this->propertyStatus;
    }

    /**
     * Set livingArea
     *
     * @param integer $livingArea
     * @return Unit
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
     * @return Unit
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
     * @return Unit
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;
    
        return $this;
    }

    /**
     * Get floor
     *
     * @return integer 
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set bedrooms
     *
     * @param integer $bedrooms
     * @return Unit
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
     * @return Unit
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
     * @return Unit
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
     * @return Unit
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
     * @return Unit
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
     * Set active
     *
     * @param boolean $active
     * @return Unit
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

    /**
     * Set generateThumbnails
     *
     * @param boolean $generateThumbnails
     * @return Unit
     */
    public function setGenerateThumbnails($generateThumbnails)
    {
        $this->generateThumbnails = $generateThumbnails;
    
        return $this;
    }

    /**
     * Get generateThumbnails
     *
     * @return boolean 
     */
    public function getGenerateThumbnails()
    {
        return $this->generateThumbnails;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     * @return Unit
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
    
        return $this;
    }

    /**
     * Get featured
     *
     * @return boolean 
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return Unit
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
     * @return Unit
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
     * Set address
     *
     * @param PHRentals\MainBundle\Entity\Address $address
     * @return Unit
     */
    public function setAddress(\PHRentals\MainBundle\Entity\Address $address = null)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return PHRentals\MainBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set owner
     *
     * @param PHRentals\MainBundle\Entity\Contact $owner
     * @return Unit
     */
    public function setOwner(\PHRentals\MainBundle\Entity\Contact $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return PHRentals\MainBundle\Entity\Contact 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set unitType
     *
     * @param PHRentals\MainBundle\Entity\UnitSize $unitSize
     * @return Unit
     */
    public function setUnitType(\PHRentals\MainBundle\Entity\UnitSize $unitSize = null)
    {
        $this->unitType = $unitSize;
    
        return $this;
    }

    /**
     * Get unitSize
     *
     * @return PHRentals\MainBundle\Entity\UnitSize 
     */
    public function getUnitType()
    {
        return $this->unitType;
    }

    /**
     * Add tags
     *
     * @param PHRentals\MainBundle\Entity\UnitTag $tags
     * @return Unit
     */
    public function addTag(\PHRentals\MainBundle\Entity\UnitTag $tags)
    {
    	if (!$this->tags->contains($tags)) {
        	$this->tags[] = $tags;
    	}
        return $this;
    }

    /**
     * Remove tags
     *
     * @param PHRentals\MainBundle\Entity\UnitTag $tags
     */
    public function removeTag(\PHRentals\MainBundle\Entity\UnitTag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    public function hasTag($search)
    {
    	foreach($this->tags as $tag) {
    		
    		if ($tag->getName() == $search) return true;
    	}
    	return false;
    }

    /**
     * Add unitSet
     *
     * @param PHRentals\MainBundle\Entity\UnitSet $unitSet
     * @return Unit
     */
    public function addUnitSet(\PHRentals\MainBundle\Entity\UnitSet $unitSet)
    {
        $this->unitSet[] = $unitSet;
    
        return $this;
    }

    /**
     * Remove unitSet
     *
     * @param PHRentals\MainBundle\Entity\UnitSet $unitSet
     */
    public function removeUnitSet(\PHRentals\MainBundle\Entity\UnitSet $unitSet)
    {
        $this->unitSet->removeElement($unitSet);
    }

    /**
     * Get unitSet
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUnitSet()
    {
        return $this->unitSet;
    }

    /**
     * Add sameUnits
     *
     * @param PHRentals\MainBundle\Entity\UnitSame $sameUnits
     * @return Unit
     */
    public function addSameUnit(\PHRentals\MainBundle\Entity\UnitSame $sameUnits)
    {
        $this->sameUnits[] = $sameUnits;
    
        return $this;
    }

    /**
     * Remove sameUnits
     *
     * @param PHRentals\MainBundle\Entity\UnitSame $sameUnits
     */
    public function removeSameUnit(\PHRentals\MainBundle\Entity\UnitSame $sameUnits)
    {
        $this->sameUnits->removeElement($sameUnits);
    }

    /**
     * Get sameUnits
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSameUnits()
    {
        return $this->sameUnits;
    }

    /**
     * Add reservations
     *
     * @param PHRentals\MainBundle\Entity\Reservation $reservations
     * @return Unit
     */
    public function addReservation(\PHRentals\MainBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;
    
        return $this;
    }

    /**
     * Remove reservations
     *
     * @param PHRentals\MainBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\PHRentals\MainBundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Set ownership
     *
     * @param string $ownership
     * @return Unit
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
     * Set completedOn
     *
     * @param \DateTime $completedOn
     * @return Unit
     */
    public function setCompletedOn($completedOn)
    {
        $this->completedOn = $completedOn;
    
        return $this;
    }

    /**
     * Get completedOn
     *
     * @return \DateTime 
     */
    public function getCompletedOn()
    {
        return $this->completedOn;
    }

    /**
     * Set incomplete
     *
     * @param boolean $incomplete
     * @return Unit
     */
    public function setIncomplete($incomplete)
    {
        $this->incomplete = $incomplete;
    
        return $this;
    }

    /**
     * Get incomplete
     *
     * @return boolean 
     */
    public function getIncomplete()
    {
        return $this->incomplete;
    }

    /**
     * Set photos
     *
     * @param boolean $photos
     * @return Unit
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    
        return $this;
    }

    /**
     * Get photos
     *
     * @return boolean 
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set chanote
     *
     * @param boolean $chanote
     * @return Unit
     */
    public function setChanote($chanote)
    {
        $this->chanote = $chanote;
    
        return $this;
    }

    /**
     * Get chanote
     *
     * @return boolean 
     */
    public function getChanote()
    {
        return $this->chanote;
    }

    /**
     * Set project
     *
     * @param PHRentals\MainBundle\Entity\Project $project
     * @return Unit
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
     * Get contracts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContracts()
    {
        return $this->contracts;
    }
    
    /**
     * Get active contracts
     *
     * @return PHRentals\MainBundle\Entity\Contract
     */
    public function getActiveContract()
    {
    	foreach($this->contracts as $contract) {
    		if($contract->getContract()->getStatus()->getId() > 2) {
    			
    			return $contract;
    			
    		}
    	}
    	return false;
    }
    
    /**
     * Get outsides
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getOutsides()
    {
    	return $this->outsides;
    }
    

    /**
     * Set createdByUser
     *
     * @param Application\Sonata\UserBundle\Entity\User $createdByUser
     * @return Unit
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
     * @return Unit
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
    
    /**
     * Set class
     *
     * @param PHRentals\MainBundle\Entity\UnitClass $class
     * @return Address
     */
    public function setClass(\PHRentals\MainBundle\Entity\UnitClass $class = null)
    {
    	$this->class = $class;
    
    	return $this;
    }
    
    /**
     * Get class
     *
     * @return PHRentals\MainBundle\Entity\AddressClass
     */
    public function getClass()
    {
    	return $this->class;
    }

    /**
     * Add contracts
     *
     * @param PHRentals\MainBundle\Entity\ContractUnit $contracts
     * @return Unit
     */
    public function addContract(\PHRentals\MainBundle\Entity\ContractUnit $contracts)
    {
        $this->contracts[] = $contracts;
    
        return $this;
    }

    /**
     * Remove contracts
     *
     * @param PHRentals\MainBundle\Entity\ContractUnit $contracts
     */
    public function removeContract(\PHRentals\MainBundle\Entity\ContractUnit $contracts)
    {
        $this->contracts->removeElement($contracts);
    }

    /**
     * Add outsides
     *
     * @param PHRentals\MainBundle\Entity\Outside $outsides
     * @return Unit
     */
    public function addOutside(\PHRentals\MainBundle\Entity\Outside $outsides)
    {
        $this->outsides[] = $outsides;
    
        return $this;
    }

    /**
     * Remove outsides
     *
     * @param PHRentals\MainBundle\Entity\Outside $outsides
     */
    public function removeOutside(\PHRentals\MainBundle\Entity\Outside $outsides)
    {
        $this->outsides->removeElement($outsides);
    }

    /**
     * Add images
     *
     * @param PHRentals\MainBundle\Entity\UnitImage $images
     * @return Unit
     */
    public function addImage(\PHRentals\MainBundle\Entity\UnitImage $images)
    {
        $this->images[] = $images;
        $images->setUnit($this);
    
        return $this;
    }
    
    public function addImages(\PHRentals\MainBundle\Entity\UnitImage $images)
    {
    	$this->images[] = $images;
    	$images->setUnit($this);
    
    	return $this;
    }

    /**
     * Remove images
     *
     * @param PHRentals\MainBundle\Entity\UnitImage $images
     */
    public function removeImage(\PHRentals\MainBundle\Entity\UnitImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
    
    public function getImage()
    {
    	return $this->images;
    }
    
    public function setImage($images)
    {
    	$this->images = $images;
    	$images->setUnit($this);
    	return $this;
    }
}