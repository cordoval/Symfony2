<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PHRentals\MainBundle\Entity\Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="PHRentals\MainBundle\Repository\ProjectRepository")
 * @UniqueEntity(fields={"name"}, message="This Project name is already used.")
 */
class Project
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
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=127, nullable=false, unique=true)
     */
    private $slug;
    
    /**
     * @var datetime $completedOn
     *
     * @ORM\Column(name="completed_on", type="datetime", nullable=true)
     */
    private $completedOn;
    
    /**
     * @ORM\OneToOne(targetEntity="Address", cascade={"all"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
    private $address;
    
    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var string $website
     *
     * @ORM\Column(name="website", type="string", nullable=true)
     */
    private $website;
    
    /**
     * @var string $furnished
     *
     * @ORM\Column(name="furnished", type="string", nullable=true)
     */
    private $furnished;
    
    /**
     * @var string $sinkingFund
     *
     * @ORM\Column(name="sinkingFund", type="string", nullable=true)
     */
    private $sinkingFund;
    
    /**
     * @var string $maintenanceFee
     *
     * @ORM\Column(name="maintenanceFee", type="string", nullable=true)
     */
    private $maintenanceFee;
    
    /**
     * @var string $startDate
     *
     * @ORM\Column(name="startDate", type="string", nullable=true)
     */
    private $startDate;
    
    /**
     * @var string $completion
     *
     * @ORM\Column(name="completion", type="string", nullable=true)
     */
    private $completion;
    
    /**
     * @var string $reservation
     *
     * @ORM\Column(name="reservation", type="string", nullable=true)
     */
    private $reservation;
    
    /**
     * @var string $deposit
     *
     * @ORM\Column(name="deposit", type="string", nullable=true)
     */
    private $deposit;
    
    /**
     * @var string $installments
     *
     * @ORM\Column(name="installments", type="string", nullable=true)
     */
    private $installments;
    
    /**
     * @var string $handover
     *
     * @ORM\Column(name="handover", type="string", nullable=true)
     */
    private $handover;
    
    /**
     * @var string $unitTypeFrom
     *
     * @ORM\Column(name="unitTypeFrom", type="string", nullable=true)
     */
    private $unitTypeFrom;
    
    /**
     * @var string $unitTypeTo
     *
     * @ORM\Column(name="unitTypeTo", type="string", nullable=true)
     */
    private $unitTypeTo;
    
    /**
     * @var string $livingAreaFrom
     *
     * @ORM\Column(name="livingAreaFrom", type="string", nullable=true)
     */
    private $livingAreaFrom;
    
    /**
     * @var string $livingAreaTo
     *
     * @ORM\Column(name="livingAreaTo", type="string", nullable=true)
     */
    private $livingAreaTo;
    
    /**
     * @var string $priceFrom
     *
     * @ORM\Column(name="priceFrom", type="string", nullable=true)
     */
    private $priceFrom;
    
    /**
     * @var string $priceTo
     *
     * @ORM\Column(name="priceTo", type="string", nullable=true)
     */
    private $priceTo;
    
    /**
     * @var string $priceSqmMin
     *
     * @ORM\Column(name="priceSqmMin", type="string", nullable=true)
     */
    private $priceSqmMin;
    
    /**
     * @var string $priceSqmMax
     *
     * @ORM\Column(name="priceSqmMax", type="string", nullable=true)
     */
    private $priceSqmMax;
    
    /**
     * @var string $studioMinSqm
     *
     * @ORM\Column(name="studioMinSqm", type="string", nullable=true)
     */
    private $studioMinSqm;
    
    /**
     * @var string $studioMinPrice
     *
     * @ORM\Column(name="studioMinPrice", type="string", nullable=true)
     */
    private $studioMinPrice;
    
    /**
     * @var string $studioMaxSqm
     *
     * @ORM\Column(name="studioMaxSqm", type="string", nullable=true)
     */
    private $studioMaxSqm;
    
    /**
     * @var string $studioMaxPrice
     *
     * @ORM\Column(name="studioMaxPrice", type="string", nullable=true)
     */
    private $studioMaxPrice;
    
    /**
     * @var string $bed1minSqm
     *
     * @ORM\Column(name="bed1minSqm", type="string", nullable=true)
     */
    private $bed1minSqm;
    
    /**
     * @var string $bed1minPrice
     *
     * @ORM\Column(name="bed1minPrice", type="string", nullable=true)
     */
    private $bed1minPrice;
    
    /**
     * @var string $bed1maxSqm
     *
     * @ORM\Column(name="bed1maxSqm", type="string", nullable=true)
     */
    private $bed1maxSqm;
    
    /**
     * @var string $bed1maxPrice
     *
     * @ORM\Column(name="bed1maxPrice", type="string", nullable=true)
     */
    private $bed1maxPrice;
    
    /**
     * @var string $bed2minSqm
     *
     * @ORM\Column(name="bed2minSqm", type="string", nullable=true)
     */
    private $bed2minSqm;
    
    /**
     * @var string $bed2minPrice
     *
     * @ORM\Column(name="bed2minPrice", type="string", nullable=true)
     */
    private $bed2minPrice;
    
    /**
     * @var string $bed2maxSqm
     *
     * @ORM\Column(name="bed2maxSqm", type="string", nullable=true)
     */
    private $bed2maxSqm;
    
    /**
     * @var string $bed2maxPrice
     *
     * @ORM\Column(name="bed2maxPrice", type="string", nullable=true)
     */
    private $bed2maxPrice;
    
    /**
     * @var string $bed3minSqm
     *
     * @ORM\Column(name="bed3minSqm", type="string", nullable=true)
     */
    private $bed3minSqm;
    
    /**
     * @var string $bed3minPrice
     *
     * @ORM\Column(name="bed3minPrice", type="string", nullable=true)
     */
    private $bed3minPrice;
    
    /**
     * @var string $bed3maxSqm
     *
     * @ORM\Column(name="bed3maxSqm", type="string", nullable=true)
     */
    private $bed3maxSqm;
    
    /**
     * @var string $bed3maxPrice
     *
     * @ORM\Column(name="bed3maxPrice", type="string", nullable=true)
     */
    private $bed3maxPrice;  
	
    /**
     * @var string $launched
     *
     * @ORM\Column(name="launched", type="string", nullable=true)
     */
    private $launched;
    
    /**
     * @var string $constructionStarts
     *
     * @ORM\Column(name="constructionStarts", type="string", nullable=true)
     */
    private $constructionStarts;
    
    /**
     * @var string $expectedCompletion
     *
     * @ORM\Column(name="expectedCompletion", type="string", nullable=true)
     */
    private $expectedCompletion;
    
    /**
     * @var string $buildDuration
     *
     * @ORM\Column(name="buildDuration", type="string", nullable=true)
     */
    private $buildDuration;
    
    /**
     * @var string $projectType
     *
     * @ORM\Column(name="projectType", type="string", nullable=true)
     */
    private $projectType;
    
    /**
     * @var string $totalBuildings
     *
     * @ORM\Column(name="totalBuildings", type="string", nullable=true)
     */
    private $totalBuildings;
    
    /**
     * @var string $totalUnits
     *
     * @ORM\Column(name="totalUnits", type="string", nullable=true)
     */
    private $totalUnits;
    
    /**
     * @var string $totalFloors
     *
     * @ORM\Column(name="totalFloors", type="string", nullable=true)
     */
    private $totalFloors;
    
    /**
     * @var string $eiaStatus
     *
     * @ORM\Column(name="eiaStatus", type="string", nullable=true)
     */
    private $eiaStatus;
    
    /**
     * @var string $sales
     *
     * @ORM\Column(name="sales", type="string", nullable=true)
     */
    private $sales;
    
    /**
     * @var string $directions
     *
     * @ORM\Column(name="directions", type="string", nullable=true)
     */
    private $directions;
    
    /**
     * @var string $configuration
     *
     * @ORM\Column(name="configuration", type="string", nullable=true)
     */
    private $configuration;
    
    /**
     * @var string $composition
     *
     * @ORM\Column(name="composition", type="string", nullable=true)
     */
    private $composition;
    
    /**
     * @var string $salesPriceGuide
     *
     * @ORM\Column(name="salesPriceGuide", type="string", nullable=true)
     */
    private $salesPriceGuide;
    
    /**
     * @var string $amenities
     *
     * @ORM\Column(name="amenities", type="text", nullable=true)
     */
    private $amenities;
    
    /**
     * @var string $security
     *
     * @ORM\Column(name="security", type="string", nullable=true)
     */
    private $security;
    
    /**
     * @var string $descriptiontext
     *
     * @ORM\Column(name="descriptiontext", type="text", nullable=true)
     */
    private $descriptiontext;
	
    /**
     * @var string $telephone
     *
     * @ORM\Column(name="telephone", type="string", nullable=true)
     */
    private $telephone;
	
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Unit", mappedBy="project")
     */
    private $units;
    

    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="projects")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * })
     */
    private $developer;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->units = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Project
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
     * Set completedOn
     *
     * @param \DateTime $completedOn
     * @return Project
     */
    public function setCompletedOn($completedOn)
    {
        $this->completedOn = $completedOn;
    
        return $this;
    }

    /**
     * Get completedOn
     *
     * @return string 
     */
    public function getCompletedOn()
    {
        return $this->completedOn;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
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
     * Set website
     *
     * @param string $website
     * @return Project
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    
        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set furnished
     *
     * @param string $furnished
     * @return Project
     */
    public function setFurnished($furnished)
    {
        $this->furnished = $furnished;
    
        return $this;
    }

    /**
     * Get furnished
     *
     * @return string 
     */
    public function getFurnished()
    {
        return $this->furnished;
    }

    /**
     * Set sinkingFund
     *
     * @param integer $sinkingFund
     * @return Project
     */
    public function setSinkingFund($sinkingFund)
    {
        $this->sinkingFund = $sinkingFund;
    
        return $this;
    }

    /**
     * Get sinkingFund
     *
     * @return integer 
     */
    public function getSinkingFund()
    {
        return $this->sinkingFund;
    }

    /**
     * Set maintenanceFee
     *
     * @param integer $maintenanceFee
     * @return Project
     */
    public function setMaintenanceFee($maintenanceFee)
    {
        $this->maintenanceFee = $maintenanceFee;
    
        return $this;
    }

    /**
     * Get maintenanceFee
     *
     * @return integer 
     */
    public function getMaintenanceFee()
    {
        return $this->maintenanceFee;
    }

    /**
     * Set startDate
     *
     * @param string $startDate
     * @return Project
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    
        return $this;
    }

    /**
     * Get startDate
     *
     * @return string 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set completion
     *
     * @param \DateTime $completion
     * @return Project
     */
    public function setCompletion($completion)
    {
        $this->completion = $completion;
    
        return $this;
    }

    /**
     * Get completion
     *
     * @return \DateTime 
     */
    public function getCompletion()
    {
        return $this->completion;
    }

    /**
     * Set paymentPlan
     *
     * @param integer $paymentPlan
     * @return Project
     */
    public function setPaymentPlan($paymentPlan)
    {
        $this->paymentPlan = $paymentPlan;
    
        return $this;
    }

    /**
     * Get paymentPlan
     *
     * @return integer 
     */
    public function getPaymentPlan()
    {
        return $this->paymentPlan;
    }

    /**
     * Set reservation
     *
     * @param integer $reservation
     * @return Project
     */
    public function setReservation($reservation)
    {
        $this->reservation = $reservation;
    
        return $this;
    }

    /**
     * Get reservation
     *
     * @return integer 
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * Set deposit
     *
     * @param integer $deposit
     * @return Project
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
     * Set installments
     *
     * @param integer $installments
     * @return Project
     */
    public function setInstallments($installments)
    {
        $this->installments = $installments;
    
        return $this;
    }

    /**
     * Get installments
     *
     * @return integer 
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * Set handover
     *
     * @param string $handover
     * @return Project
     */
    public function setHandover($handover)
    {
        $this->handover = $handover;
    
        return $this;
    }

    /**
     * Get handover
     *
     * @return string 
     */
    public function getHandover()
    {
        return $this->handover;
    }

    /**
     * Set priceSqmMin
     *
     * @param integer $priceSqmMin
     * @return Project
     */
    public function setPriceSqmMin($priceSqmMin)
    {
        $this->priceSqmMin = $priceSqmMin;
    
        return $this;
    }

    /**
     * Get priceSqmMin
     *
     * @return integer 
     */
    public function getPriceSqmMin()
    {
        return $this->priceSqmMin;
    }

    /**
     * Set priceSqmMax
     *
     * @param integer $priceSqmMax
     * @return Project
     */
    public function setPriceSqmMax($priceSqmMax)
    {
        $this->priceSqmMax = $priceSqmMax;
    
        return $this;
    }

    /**
     * Get priceSqmMax
     *
     * @return integer 
     */
    public function getPriceSqmMax()
    {
        return $this->priceSqmMax;
    }

    /**
     * Set studioMinSqm
     *
     * @param integer $studioMinSqm
     * @return Project
     */
    public function setStudioMinSqm($studioMinSqm)
    {
        $this->studioMinSqm = $studioMinSqm;
    
        return $this;
    }

    /**
     * Get studioMinSqm
     *
     * @return integer 
     */
    public function getStudioMinSqm()
    {
        return $this->studioMinSqm;
    }

    /**
     * Set studioMinPrice
     *
     * @param integer $studioMinPrice
     * @return Project
     */
    public function setStudioMinPrice($studioMinPrice)
    {
        $this->studioMinPrice = $studioMinPrice;
    
        return $this;
    }

    /**
     * Get studioMinPrice
     *
     * @return integer 
     */
    public function getStudioMinPrice()
    {
        return $this->studioMinPrice;
    }

    /**
     * Set studioMaxSqm
     *
     * @param integer $studioMaxSqm
     * @return Project
     */
    public function setStudioMaxSqm($studioMaxSqm)
    {
        $this->studioMaxSqm = $studioMaxSqm;
    
        return $this;
    }

    /**
     * Get studioMaxSqm
     *
     * @return integer 
     */
    public function getStudioMaxSqm()
    {
        return $this->studioMaxSqm;
    }

    /**
     * Set studioMaxPrice
     *
     * @param integer $studioMaxPrice
     * @return Project
     */
    public function setStudioMaxPrice($studioMaxPrice)
    {
        $this->studioMaxPrice = $studioMaxPrice;
    
        return $this;
    }

    /**
     * Get studioMaxPrice
     *
     * @return integer 
     */
    public function getStudioMaxPrice()
    {
        return $this->studioMaxPrice;
    }

    /**
     * Set bed1minSqm
     *
     * @param integer $bed1minSqm
     * @return Project
     */
    public function setBed1minSqm($bed1minSqm)
    {
        $this->bed1minSqm = $bed1minSqm;
    
        return $this;
    }

    /**
     * Get bed1minSqm
     *
     * @return integer 
     */
    public function getBed1minSqm()
    {
        return $this->bed1minSqm;
    }

    /**
     * Set bed1minPrice
     *
     * @param integer $bed1minPrice
     * @return Project
     */
    public function setBed1minPrice($bed1minPrice)
    {
        $this->bed1minPrice = $bed1minPrice;
    
        return $this;
    }

    /**
     * Get bed1minPrice
     *
     * @return integer 
     */
    public function getBed1minPrice()
    {
        return $this->bed1minPrice;
    }

    /**
     * Set bed1maxSqm
     *
     * @param integer $bed1maxSqm
     * @return Project
     */
    public function setBed1maxSqm($bed1maxSqm)
    {
        $this->bed1maxSqm = $bed1maxSqm;
    
        return $this;
    }

    /**
     * Get bed1maxSqm
     *
     * @return integer 
     */
    public function getBed1maxSqm()
    {
        return $this->bed1maxSqm;
    }

    /**
     * Set bed1maxPrice
     *
     * @param integer $bed1maxPrice
     * @return Project
     */
    public function setBed1maxPrice($bed1maxPrice)
    {
        $this->bed1maxPrice = $bed1maxPrice;
    
        return $this;
    }

    /**
     * Get bed1maxPrice
     *
     * @return integer 
     */
    public function getBed1maxPrice()
    {
        return $this->bed1maxPrice;
    }

    /**
     * Set bed2minSqm
     *
     * @param integer $bed2minSqm
     * @return Project
     */
    public function setBed2minSqm($bed2minSqm)
    {
        $this->bed2minSqm = $bed2minSqm;
    
        return $this;
    }

    /**
     * Get bed2minSqm
     *
     * @return integer 
     */
    public function getBed2minSqm()
    {
        return $this->bed2minSqm;
    }

    /**
     * Set bed2minPrice
     *
     * @param integer $bed2minPrice
     * @return Project
     */
    public function setBed2minPrice($bed2minPrice)
    {
        $this->bed2minPrice = $bed2minPrice;
    
        return $this;
    }

    /**
     * Get bed2minPrice
     *
     * @return integer 
     */
    public function getBed2minPrice()
    {
        return $this->bed2minPrice;
    }

    /**
     * Set bed2maxSqm
     *
     * @param integer $bed2maxSqm
     * @return Project
     */
    public function setBed2maxSqm($bed2maxSqm)
    {
        $this->bed2maxSqm = $bed2maxSqm;
    
        return $this;
    }

    /**
     * Get bed2maxSqm
     *
     * @return integer 
     */
    public function getBed2maxSqm()
    {
        return $this->bed2maxSqm;
    }

    /**
     * Set bed2maxPrice
     *
     * @param integer $bed2maxPrice
     * @return Project
     */
    public function setBed2maxPrice($bed2maxPrice)
    {
        $this->bed2maxPrice = $bed2maxPrice;
    
        return $this;
    }

    /**
     * Get bed2maxPrice
     *
     * @return integer 
     */
    public function getBed2maxPrice()
    {
        return $this->bed2maxPrice;
    }

    /**
     * Set bed3minSqm
     *
     * @param integer $bed3minSqm
     * @return Project
     */
    public function setBed3minSqm($bed3minSqm)
    {
        $this->bed3minSqm = $bed3minSqm;
    
        return $this;
    }

    /**
     * Get bed3minSqm
     *
     * @return integer 
     */
    public function getBed3minSqm()
    {
        return $this->bed3minSqm;
    }

    /**
     * Set bed3minPrice
     *
     * @param integer $bed3minPrice
     * @return Project
     */
    public function setBed3minPrice($bed3minPrice)
    {
        $this->bed3minPrice = $bed3minPrice;
    
        return $this;
    }

    /**
     * Get bed3minPrice
     *
     * @return integer 
     */
    public function getBed3minPrice()
    {
        return $this->bed3minPrice;
    }

    /**
     * Set bed3maxSqm
     *
     * @param integer $bed3maxSqm
     * @return Project
     */
    public function setBed3maxSqm($bed3maxSqm)
    {
        $this->bed3maxSqm = $bed3maxSqm;
    
        return $this;
    }

    /**
     * Get bed3maxSqm
     *
     * @return integer 
     */
    public function getBed3maxSqm()
    {
        return $this->bed3maxSqm;
    }

    /**
     * Set bed3maxPrice
     *
     * @param integer $bed3maxPrice
     * @return Project
     */
    public function setBed3maxPrice($bed3maxPrice)
    {
        $this->bed3maxPrice = $bed3maxPrice;
    
        return $this;
    }

    /**
     * Get bed3maxPrice
     *
     * @return integer 
     */
    public function getBed3maxPrice()
    {
        return $this->bed3maxPrice;
    }

    /**
     * Set address
     *
     * @param PHRentals\MainBundle\Entity\Address $address
     * @return Project
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
     * Add units
     *
     * @param PHRentals\MainBundle\Entity\Unit $units
     * @return Project
     */
    public function addUnit(\PHRentals\MainBundle\Entity\Unit $units)
    {
        $this->units[] = $units;
    
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

    /**
     * Set developer
     *
     * @param PHRentals\MainBundle\Entity\Contact $developer
     * @return Project
     */
    public function setDeveloper(\PHRentals\MainBundle\Entity\Contact $developer = null)
    {
        $this->developer = $developer;
    
        return $this;
    }

    /**
     * Get developer
     *
     * @return PHRentals\MainBundle\Entity\Contact 
     */
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * Set launched
     *
     * @param string $launched
     * @return Project
     */
    public function setLaunched($launched)
    {
        $this->launched = $launched;
    
        return $this;
    }

    /**
     * Get launched
     *
     * @return string 
     */
    public function getLaunched()
    {
        return $this->launched;
    }

    /**
     * Set constructionStarts
     *
     * @param string $constructionStarts
     * @return Project
     */
    public function setConstructionStarts($constructionStarts)
    {
        $this->constructionStarts = $constructionStarts;
    
        return $this;
    }

    /**
     * Get constructionStarts
     *
     * @return string 
     */
    public function getConstructionStarts()
    {
        return $this->constructionStarts;
    }

    /**
     * Set expectedCompletion
     *
     * @param string $expectedCompletion
     * @return Project
     */
    public function setExpectedCompletion($expectedCompletion)
    {
        $this->expectedCompletion = $expectedCompletion;
    
        return $this;
    }

    /**
     * Get expectedCompletion
     *
     * @return string 
     */
    public function getExpectedCompletion()
    {
        return $this->expectedCompletion;
    }

    /**
     * Set buildDuration
     *
     * @param string $buildDuration
     * @return Project
     */
    public function setBuildDuration($buildDuration)
    {
        $this->buildDuration = $buildDuration;
    
        return $this;
    }

    /**
     * Get buildDuration
     *
     * @return string 
     */
    public function getBuildDuration()
    {
        return $this->buildDuration;
    }

    /**
     * Set projectType
     *
     * @param string $projectType
     * @return Project
     */
    public function setProjectType($projectType)
    {
        $this->projectType = $projectType;
    
        return $this;
    }

    /**
     * Get projectType
     *
     * @return string 
     */
    public function getProjectType()
    {
        return $this->projectType;
    }

    /**
     * Set totalBuildings
     *
     * @param string $totalBuildings
     * @return Project
     */
    public function setTotalBuildings($totalBuildings)
    {
        $this->totalBuildings = $totalBuildings;
    
        return $this;
    }

    /**
     * Get totalBuildings
     *
     * @return string 
     */
    public function getTotalBuildings()
    {
        return $this->totalBuildings;
    }

    /**
     * Set totalUnits
     *
     * @param string $totalUnits
     * @return Project
     */
    public function setTotalUnits($totalUnits)
    {
        $this->totalUnits = $totalUnits;
    
        return $this;
    }

    /**
     * Get totalUnits
     *
     * @return string 
     */
    public function getTotalUnits()
    {
        return $this->totalUnits;
    }

    /**
     * Set totalFloors
     *
     * @param string $totalFloors
     * @return Project
     */
    public function setTotalFloors($totalFloors)
    {
        $this->totalFloors = $totalFloors;
    
        return $this;
    }

    /**
     * Get totalFloors
     *
     * @return string 
     */
    public function getTotalFloors()
    {
        return $this->totalFloors;
    }

    /**
     * Set eiaStatus
     *
     * @param string $eiaStatus
     * @return Project
     */
    public function setEiaStatus($eiaStatus)
    {
        $this->eiaStatus = $eiaStatus;
    
        return $this;
    }

    /**
     * Get eiaStatus
     *
     * @return string 
     */
    public function getEiaStatus()
    {
        return $this->eiaStatus;
    }

    /**
     * Set sales
     *
     * @param string $sales
     * @return Project
     */
    public function setSales($sales)
    {
        $this->sales = $sales;
    
        return $this;
    }

    /**
     * Get sales
     *
     * @return string 
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * Set directions
     *
     * @param string $directions
     * @return Project
     */
    public function setDirections($directions)
    {
        $this->directions = $directions;
    
        return $this;
    }

    /**
     * Get directions
     *
     * @return string 
     */
    public function getDirections()
    {
        return $this->directions;
    }

    /**
     * Set configuration
     *
     * @param string $configuration
     * @return Project
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    
        return $this;
    }

    /**
     * Get configuration
     *
     * @return string 
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Set composition
     *
     * @param string $composition
     * @return Project
     */
    public function setComposition($composition)
    {
        $this->composition = $composition;
    
        return $this;
    }

    /**
     * Get composition
     *
     * @return string 
     */
    public function getComposition()
    {
        return $this->composition;
    }

    /**
     * Set salesPriceGuide
     *
     * @param string $salesPriceGuide
     * @return Project
     */
    public function setSalesPriceGuide($salesPriceGuide)
    {
        $this->salesPriceGuide = $salesPriceGuide;
    
        return $this;
    }

    /**
     * Get salesPriceGuide
     *
     * @return string 
     */
    public function getSalesPriceGuide()
    {
        return $this->salesPriceGuide;
    }

    /**
     * Set amenities
     *
     * @param string $amenities
     * @return Project
     */
    public function setAmenities($amenities)
    {
        $this->amenities = $amenities;
    
        return $this;
    }

    /**
     * Get amenities
     *
     * @return string 
     */
    public function getAmenities()
    {
        return $this->amenities;
    }

    /**
     * Set security
     *
     * @param string $security
     * @return Project
     */
    public function setSecurity($security)
    {
        $this->security = $security;
    
        return $this;
    }

    /**
     * Get security
     *
     * @return string 
     */
    public function getSecurity()
    {
        return $this->security;
    }

    /**
     * Set descriptiontext
     *
     * @param string $descriptiontext
     * @return Project
     */
    public function setDescriptiontext($descriptiontext)
    {
        $this->descriptiontext = $descriptiontext;
    
        return $this;
    }

    /**
     * Get descriptiontext
     *
     * @return string 
     */
    public function getDescriptiontext()
    {
        return $this->descriptiontext;
    }
	
    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Project
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
    
    /**
     * isOffplan
     *
     * @return boolean
     */
    public function isOffplan()
    {
    	$today = new \DateTime();
    	if($this->completedOn > $today) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    
    
    

    /**
     * Set unitTypeFrom
     *
     * @param string $unitTypeFrom
     * @return Project
     */
    public function setUnitTypeFrom($unitTypeFrom)
    {
        $this->unitTypeFrom = $unitTypeFrom;
    
        return $this;
    }

    /**
     * Get unitTypeFrom
     *
     * @return string 
     */
    public function getUnitTypeFrom()
    {
        return $this->unitTypeFrom;
    }

    /**
     * Set unitTypeTo
     *
     * @param string $unitTypeTo
     * @return Project
     */
    public function setUnitTypeTo($unitTypeTo)
    {
        $this->unitTypeTo = $unitTypeTo;
    
        return $this;
    }

    /**
     * Get unitTypeTo
     *
     * @return string 
     */
    public function getUnitTypeTo()
    {
        return $this->unitTypeTo;
    }

    /**
     * Set livingAreaFrom
     *
     * @param string $livingAreaFrom
     * @return Project
     */
    public function setLivingAreaFrom($livingAreaFrom)
    {
        $this->livingAreaFrom = $livingAreaFrom;
    
        return $this;
    }

    /**
     * Get livingAreaFrom
     *
     * @return string 
     */
    public function getLivingAreaFrom()
    {
        return $this->livingAreaFrom;
    }

    /**
     * Set livingAreaTo
     *
     * @param string $livingAreaTo
     * @return Project
     */
    public function setLivingAreaTo($livingAreaTo)
    {
        $this->livingAreaTo = $livingAreaTo;
    
        return $this;
    }

    /**
     * Get livingAreaTo
     *
     * @return string 
     */
    public function getLivingAreaTo()
    {
        return $this->livingAreaTo;
    }

    /**
     * Set priceFrom
     *
     * @param string $priceFrom
     * @return Project
     */
    public function setPriceFrom($priceFrom)
    {
        $this->priceFrom = $priceFrom;
    
        return $this;
    }

    /**
     * Get priceFrom
     *
     * @return string 
     */
    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    /**
     * Set priceTo
     *
     * @param string $priceTo
     * @return Project
     */
    public function setPriceTo($priceTo)
    {
        $this->priceTo = $priceTo;
    
        return $this;
    }

    /**
     * Get priceTo
     *
     * @return string 
     */
    public function getPriceTo()
    {
        return $this->priceTo;
    }
}