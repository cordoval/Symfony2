<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\ContractUnit
 *
 * @ORM\Table(name="contract_unit")
 * @ORM\Entity
 */
class ContractUnit
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
	 * @var string $incontract
	 *
	 * @ORM\Column(name="incontract", type="boolean", nullable=true)
	 */
	private $incontract = true;
	
    /**
     * @var string $notes
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;
    
    /**
     * @var Unit
     *
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="contracts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     * })
     */
    private $unit;
    
    /**
     * @var Contract
     *
     * @ORM\ManyToOne(targetEntity="Contract", inversedBy="units")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contract_id", referencedColumnName="id")
     * })
     */
    private $contract;
    
    /**
     * @var ArrayCollection $ranges
     *
     * @ORM\OneToMany(targetEntity="ContractUnitRanges", mappedBy="contract_unit", cascade={"all"}, orphanRemoval=true)
     */
    private $ranges;
    
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
     * @var string $keysAtText
     *
     * @ORM\Column(name="keys_at_text", type="text", nullable=true)
     */
    private $keysAtText;
    
    /**
     * @var date $availableFrom
     *
     * @ORM\Column(name="available_from", type="datetime", nullable=true)
     */
    private $availableFrom;
    
    /**
     * @var date $moveinOn
     *
     * @ORM\Column(name="movein_on", type="datetime", nullable=true)
     */
    private $moveinOn;

    /**
     * @var integer $salePricePerSqm
     *
     * @ORM\Column(name="sale_price_sqm", type="integer", nullable=true)
     */
    private $salePricePerSqm;
    
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
     * @var string $salePriceWords
     *
     * @ORM\Column(name="sale_price_words", type="string", nullable=true)
     */
    private $salePriceWords;
    
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="PaymentType")
     * @ORM\JoinTable(name="contract_has_payment_types",
     *   joinColumns={
     *     @ORM\JoinColumn(name="contract_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="payment_type_id", referencedColumnName="id")
     *   }
     * )
     */
    //private $paymentTypes;
    
    /**
     * @var string $dueDatePayment
     *
     * @ORM\Column(name="due_date_payment", type="string", nullable=true)
     */
    //private $dueDatePayment;
    
    /**
     * @var integer $daysPayable
     *
     * @ORM\Column(name="days_payable", type="integer", nullable=true)
     */
    //private $daysPayable;
    
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
     * @var string $rentalMonthlyWords
     *
     * @ORM\Column(name="payment_words", type="string", nullable=true)
     */
    private $rentalMonthlyWords;
    
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
     * @var string $baseRate
     *
     * @ORM\Column(name="base_rate", type="integer", nullable=false)
     */
    //private $baseRate;
    
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
     * @var string $extraNotes
     *
     * @ORM\Column(name="extra_notes", type="text", length=255, nullable=true)
     */
    private $extraNotes;
    
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
     * @ORM\Column(name="checkin_times", type="string", length=255, nullable=false)
     */
    private $checkinTimes = "14:00";
    
    /**
     * @var string $checkoutTimes
     *
     * @ORM\Column(name="checkout_times", type="string", length=255, nullable=false)
     */
    private $checkoutTimes = "10:00";
    
    /**
     * @var boolean $isOwnerCaretaker
     *
     * @ORM\Column(name="is_owner_care", type="boolean", nullable=true)
     */
    private $isOwnerCaretaker = true;
    
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
    
    /**
     * @var date $leaseStartOn
     *
     * @ORM\Column(name="lease_start_on", type="datetime", nullable=true)
     */
    private $leaseStartOn;
    
    /**
     * @var integer $leaseNbMonths
     *
     * @ORM\Column(name="lease_months", type="integer", nullable=true)
     */
    private $leaseNbMonths;
     
    /**
     * @var date $leaseAgreementDate
     *
     * @ORM\Column(name="owner_agreement_date", type="datetime", nullable=true)
     */
    private $leaseAgreementDate;
    
    /**
     * @var string $agent
     *
     * @ORM\Column(name="agent", type="string", length=255, nullable=true)
     */
    private $agent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ranges = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->getContract()->getKRef();
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
     * Set incontract
     *
     * @param boolean $incontract
     * @return ContractUnit
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
     * Set notes
     *
     * @param string $notes
     * @return ContractUnit
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
     * Set inspection
     *
     * @param string $inspection
     * @return ContractUnit
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
     * @return ContractUnit
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
     * Set keysAtText
     *
     * @param string $keysAtText
     * @return ContractUnit
     */
    public function setKeysAtText($keysAtText)
    {
        $this->keysAtText = $keysAtText;
    
        return $this;
    }

    /**
     * Get keysAtText
     *
     * @return string 
     */
    public function getKeysAtText()
    {
        return $this->keysAtText;
    }

    /**
     * Set availableFrom
     *
     * @param \DateTime $availableFrom
     * @return ContractUnit
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
     * Set moveinOn
     *
     * @param \DateTime $moveinOn
     * @return ContractUnit
     */
    public function setMoveinOn($moveinOn)
    {
        $this->moveinOn = $moveinOn;
    
        return $this;
    }

    /**
     * Get moveinOn
     *
     * @return \DateTime 
     */
    public function getMoveinOn()
    {
        return $this->moveinOn;
    }

    /**
     * Set salePricePerSqm
     *
     * @param integer $salePricePerSqm
     * @return ContractUnit
     */
    public function setSalePricePerSqm($salePricePerSqm)
    {
        $this->salePricePerSqm = $salePricePerSqm;
    
        return $this;
    }

    /**
     * Get salePricePerSqm
     *
     * @return integer 
     */
    public function getSalePricePerSqm()
    {
        return $this->salePricePerSqm;
    }

    /**
     * Set salePrice
     *
     * @param integer $salePrice
     * @return ContractUnit
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
     * @return ContractUnit
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
     * Set salePriceWords
     *
     * @param string $salePriceWords
     * @return ContractUnit
     */
    public function setSalePriceWords($salePriceWords)
    {
        $this->salePriceWords = $salePriceWords;
    
        return $this;
    }

    /**
     * Get salePriceWords
     *
     * @return string 
     */
    public function getSalePriceWords()
    {
        return $this->salePriceWords;
    }

    /**
     * Set transferFeeBy
     *
     * @param string $transferFeeBy
     * @return ContractUnit
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
     * Set deposit
     *
     * @param string $deposit
     * @return ContractUnit
     */
    public function setDeposit($deposit)
    {
        $this->deposit = $deposit;
    
        return $this;
    }

    /**
     * Get deposit
     *
     * @return string 
     */
    public function getDeposit()
    {
        return $this->deposit;
    }

    /**
     * Set maxRepairCostPerMonth
     *
     * @param integer $maxRepairCostPerMonth
     * @return ContractUnit
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
     * Set rentalMonthlyWords
     *
     * @param string $rentalMonthlyWords
     * @return ContractUnit
     */
    public function setRentalMonthlyWords($rentalMonthlyWords)
    {
        $this->rentalMonthlyWords = $rentalMonthlyWords;
    
        return $this;
    }

    /**
     * Get rentalMonthlyWords
     *
     * @return string 
     */
    public function getRentalMonthlyWords()
    {
        return $this->rentalMonthlyWords;
    }

    /**
     * Set payment
     *
     * @param integer $payment
     * @return ContractUnit
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    
        return $this;
    }

    /**
     * Get payment
     *
     * @return integer 
     */
    public function getPayment()
    {
        return $this->payment;
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
     * @return ContractUnit
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
     * @return ContractUnit
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
     * @return ContractUnit
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
     * @return ContractUnit
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
     * @return ContractUnit
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
     * Set extraNotes
     *
     * @param string $extraNotes
     * @return ContractUnit
     */
    public function setExtraNotes($extraNotes)
    {
        $this->extraNotes = $extraNotes;
    
        return $this;
    }

    /**
     * Get extraNotes
     *
     * @return string 
     */
    public function getExtraNotes()
    {
        return $this->extraNotes;
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
     * @return ContractUnit
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
     * @return ContractUnit
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
     * @return ContractUnit
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
     * @return ContractUnit
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
     * @return ContractUnit
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
     * @return ContractUnit
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
     * Set leaseStartOn
     *
     * @param \DateTime $leaseStartOn
     * @return ContractUnit
     */
    public function setLeaseStartOn($leaseStartOn)
    {
        $this->leaseStartOn = $leaseStartOn;
    
        return $this;
    }

    /**
     * Get leaseStartOn
     *
     * @return \DateTime 
     */
    public function getLeaseStartOn()
    {
        return $this->leaseStartOn;
    }

    /**
     * Set leaseNbMonths
     *
     * @param integer $leaseNbMonths
     * @return ContractUnit
     */
    public function setLeaseNbMonths($leaseNbMonths)
    {
        $this->leaseNbMonths = $leaseNbMonths;
    
        return $this;
    }

    /**
     * Get leaseNbMonths
     *
     * @return integer 
     */
    public function getLeaseNbMonths()
    {
        return $this->leaseNbMonths;
    }

    /**
     * Set leaseAgreementDate
     *
     * @param \DateTime $leaseAgreementDate
     * @return ContractUnit
     */
    public function setLeaseAgreementDate($leaseAgreementDate)
    {
        $this->leaseAgreementDate = $leaseAgreementDate;
    
        return $this;
    }

    /**
     * Get leaseAgreementDate
     *
     * @return \DateTime 
     */
    public function getLeaseAgreementDate()
    {
        return $this->leaseAgreementDate;
    }

    /**
     * Set agent
     *
     * @param string $agent
     * @return ContractUnit
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    
        return $this;
    }

    /**
     * Get agent
     *
     * @return string 
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set unit
     *
     * @param PHRentals\MainBundle\Entity\Unit $unit
     * @return ContractUnit
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
     * Set contract
     *
     * @param PHRentals\MainBundle\Entity\Contract $contract
     * @return ContractUnit
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
     * Add paymentTypes
     *
     * @param PHRentals\MainBundle\Entity\PaymentType $paymentTypes
     * @return ContractUnit
     */
    public function addPaymentType(\PHRentals\MainBundle\Entity\PaymentType $paymentTypes)
    {
    	$this->paymentTypes->removeElement($paymentTypes);
        $this->paymentTypes[] = $paymentTypes;
    
        return $this;
    }

    /**
     * Remove paymentTypes
     *
     * @param PHRentals\MainBundle\Entity\PaymentType $paymentTypes
     */
    public function removePaymentType(\PHRentals\MainBundle\Entity\PaymentType $paymentTypes)
    {
        $this->paymentTypes->removeElement($paymentTypes);
    }

    /**
     * Get paymentTypes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPaymentTypes()
    {
        return $this->paymentTypes;
    }

    /**
     * Add ranges
     *
     * @param PHRentals\MainBundle\Entity\ContractUnitRanges $ranges
     * @return ContractUnit
     */
    public function addRange(\PHRentals\MainBundle\Entity\ContractUnitRanges $ranges)
    {
        $this->ranges[] = $ranges;
        $ranges->setContractUnit($this);
    
        return $this;
    }
    public function addRanges(\PHRentals\MainBundle\Entity\ContractUnitRanges $ranges)
    {
    	$this->ranges[] = $ranges;
    	$ranges->setContractUnit($this);
    
    	return $this;
    }
    /**
     * Remove ranges
     *
     * @param PHRentals\MainBundle\Entity\ContractUnitRanges $ranges
     */
    public function removeRange(\PHRentals\MainBundle\Entity\ContractUnitRanges $ranges)
    {
        $this->ranges->removeElement($ranges);
    }

    /**
     * Get ranges
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRanges()
    {
        return $this->ranges;
    }
    public function getRange()
    {
    	return $this->ranges;
    }
    public function setRanges($ranges)
    {
    	$this->ranges = $ranges;
    	return $this;
    }
    
    /**
     * isOffplan
     *
     * @return boolean
     */
    public function isAvailable()
    {
    	$available = true;
    	$today = new \DateTime();
    	
    	foreach($this->ranges as $range) {
    		if ($range->getDateFrom() <= $today && $range->getDateTo() > $today) {
    			$available = false;
    		}
    		
    	}
    	if($this->availableFrom > $today) {
    		$available = false;
    	}

    	return $available;
    }
    
    
}