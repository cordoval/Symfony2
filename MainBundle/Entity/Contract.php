<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * PHRentals\MainBundle\Entity\Contract
 *
 * @ORM\Table(name="contract")
 * @ORM\Entity(repositoryClass="PHRentals\MainBundle\Repository\ContractRepository")
 * @UniqueEntity(fields={"kRef"}, message="Reference of contract (K-Ref) is already used.")
 * @ORM\HasLifecycleCallbacks 
 */
class Contract
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
     * @var string $kRef
     *
     * @ORM\Column(name="k_ref", type="string", length=127, nullable=true, unique=true)
     */
    private $kRef;
    
    /**
     * @var Owner
     *
     * @ORM\ManyToOne(targetEntity="Contact")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * })
     */
    private $owner;
    
    /**
     * @var ContractUnit
     *
     * @ORM\OnetoMany(targetEntity="ContractUnit", mappedBy="contract", cascade={"all"}, orphanRemoval=true)
     */
    private $units;
    
    /**
     * @var integer $unitNb
     *
     * @ORM\Column(name="unit_nb", type="integer", nullable=false)
     */
    private $unitNb = '1';
    
    /**
     * @var date $agreementDate
     *
     * @ORM\Column(name="agreement_date", type="datetime", nullable=true)
     */
    private $agreementDate;
    
    /**
     * @var Purpose
     *
     * @ORM\ManyToOne(targetEntity="ContractPurpose")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="purpose_id", referencedColumnName="id")
     * })
     */
    private $purpose;

    /**
     * @var string $origin
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=true)
     */
    private $origin;
    
    public static function getOriginList()
    {
    	return array(
    			'email/website' => 'email/website',
    			'phone' =>'phone',
    			'fax' =>'fax',
    			'walk-in' =>'walk-in',
    			'own' =>'own',
    			'via company' =>'via company'
    	);
    }
    
    /**
     * @var ContractStatus
     *
     * @ORM\ManyToOne(targetEntity="ContractStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $status;
    
   
    /**
     * @var string $commission
     *
     * @ORM\Column(name="commission", type="string", length=255, nullable=true)
     */
    private $commission;
    
    public static function getCommissionList()
    {
    	return array(
    			'Premium' => 'Premium',
    			'Regular' => 'Regular',
    			'Via agent' => 'Via agent'
    	);
    }
    
    /**
     * @var string $agencyFee
     *
     * @ORM\Column(name="agency_fee", type="float", nullable=true)
     */
    private $agencyFee;
    
    /**
     * @var string $agencyFeeWords
     *
     * @ORM\Column(name="agency_fee_words", type="string", nullable=true)
     */
    private $agencyFeeWords;
    
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
    
    /**
     * @var boolean $isContractSigned
     *
     * @ORM\Column(name="is_contract_signed", type="boolean", nullable=true)
     */
    private $isContractSigned;
    
    /**
     * @var date $dateContractSigned
     *
     * @ORM\Column(name="date_contract_signed", type="datetime", nullable=true)
     */
    private $dateContractSigned;
    
    /**
     * @var date $dateExpiration
     *
     * @ORM\Column(name="date_expiration", type="datetime", nullable=true)
     */
    private $dateExpiration;
    
    /**
     * @var string $remarks
     *
     * @ORM\Column(name="remarks", type="text", nullable=true)
     */
    private $remarks;
    
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
     * @var date $validatedOn
     *
     * @ORM\Column(name="validated_on", type="datetime", nullable=true)
     */
    private $validatedOn;
    
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
    	$this->units = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->getKRef();
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
     * Set kRef
     *
     * @param string $kRef
     * @return Contract
     */
    public function setKRef($kRef)
    {
        $this->kRef = $kRef;
    
        return $this;
    }

    /**
     * Get kRef
     *
     * @return string 
     */
    public function getKRef()
    {
        return $this->kRef;
    }

    /**
     * Set agreementDate
     *
     * @param \DateTime $agreementDate
     * @return Contract
     */
    public function setAgreementDate($agreementDate)
    {
        $this->agreementDate = $agreementDate;
    
        return $this;
    }

    /**
     * Get agreementDate
     *
     * @return \DateTime 
     */
    public function getAgreementDate()
    {
        return $this->agreementDate;
    }

    /**
     * Set origin
     *
     * @param string $origin
     * @return Contract
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    
        return $this;
    }

    /**
     * Get origin
     *
     * @return string 
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set ownership
     *
     * @param string $ownership
     * @return Contract
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
     * Set inspection
     *
     * @param string $inspection
     * @return Contract
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
     * @return Contract
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
     * @return Contract
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
     * Set validatedOn
     *
     * @param \DateTime $validatedOn
     * @return Contract
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
     * Set active
     *
     * @param boolean $active
     * @return Contract
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
     * Set agencyFee
     *
     * @param float $agencyFee
     * @return Contract
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
     * Set agencyFeeWords
     *
     * @param string $agencyFeeWords
     * @return Contract
     */
    public function setAgencyFeeWords($agencyFeeWords)
    {
    	$this->agencyFeeWords = $agencyFeeWords;
    
    	return $this;
    }
    
    /**
     * Get agencyFeeWords
     *
     * @return string
     */
    public function getAgencyFeeWords()
    {
    	return $this->agencyFeeWords;
    }

    /**
     * Set agencyDepositRate
     *
     * @param float $agencyDepositRate
     * @return Contract
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
     * Set unitNb
     *
     * @param integer $unitNb
     * @return Contract
     */
    public function setUnitNb($unitNb)
    {
        $this->unitNb = $unitNb;
    
        return $this;
    }

    /**
     * Get unitNb
     *
     * @return integer 
     */
    public function getUnitNb()
    {
        return $this->unitNb;
    }

    /**
     * Set commission
     *
     * @param string $commission
     * @return Contract
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
    
        return $this;
    }

    /**
     * Get commission
     *
     * @return string 
     */
    public function getCommission()
    {
        return $this->commission;
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
     * Set isContractSigned
     *
     * @param boolean $isContractSigned
     * @return Contract
     */
    public function setIsContractSigned($isContractSigned)
    {
        $this->isContractSigned = $isContractSigned;
    
        return $this;
    }

    /**
     * Get isContractSigned
     *
     * @return boolean 
     */
    public function getIsContractSigned()
    {
        return $this->isContractSigned;
    }

    /**
     * Set dateContractSigned
     *
     * @param \DateTime $dateContractSigned
     * @return Contract
     */
    public function setDateContractSigned($dateContractSigned)
    {
        $this->dateContractSigned = $dateContractSigned;
    
        return $this;
    }

    /**
     * Get dateContractSigned
     *
     * @return \DateTime 
     */
    public function getDateContractSigned()
    {
        return $this->dateContractSigned;
    }

    /**
     * Set dateExpiration
     *
     * @param \DateTime $dateExpiration
     * @return Contract
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;
    
        return $this;
    }

    /**
     * Get dateExpiration
     *
     * @return \DateTime 
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return Contract
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
     * @return Contract
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
     * Set owner
     *
     * @param PHRentals\MainBundle\Entity\Contact $owner
     * @return Contract
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
     * Add units
     *
     * @param PHRentals\MainBundle\Entity\ContractUnit $units
     * @return Contract
     */
    public function addUnit(\PHRentals\MainBundle\Entity\ContractUnit $units)
    {
        $this->units[] = $units;
    
        return $this;
    }

    /**
     * Remove units
     *
     * @param PHRentals\MainBundle\Entity\ContractUnit $units
     */
    public function removeUnit(\PHRentals\MainBundle\Entity\ContractUnit $units)
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
    
    public function getUnitList()
    {
   		$unit_list = array();
    	foreach ($this->getUnits() as $unit) {
    		$unit_list[] = $unit->getUnit();
    	}	
    	return $unit_list;
    }

    /**
     * Set purpose
     *
     * @param PHRentals\MainBundle\Entity\ContractPurpose $purpose
     * @return Contract
     */
    public function setPurpose(\PHRentals\MainBundle\Entity\ContractPurpose $purpose = null)
    {
        $this->purpose = $purpose;
    
        return $this;
    }

    /**
     * Get purpose
     *
     * @return PHRentals\MainBundle\Entity\ContractPurpose 
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * Set status
     *
     * @param PHRentals\MainBundle\Entity\ContractStatus $status
     * @return Contract
     */
    public function setStatus(\PHRentals\MainBundle\Entity\ContractStatus $status = null)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return PHRentals\MainBundle\Entity\ContractStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set validatedByUser
     *
     * @param Application\Sonata\UserBundle\Entity\User $validatedByUser
     * @return Contract
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
     * Set createdByUser
     *
     * @param Application\Sonata\UserBundle\Entity\User $createdByUser
     * @return Contract
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
     * @return Contract
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