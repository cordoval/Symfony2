<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\ContractUnitRanges
 *
 * @ORM\Table(name="contract_unit_ranges")
 * @ORM\Entity
 */
class ContractUnitRanges
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
	 * @var date $dateFrom
	 *
	 * @ORM\Column(name="date_from", type="datetime", nullable=true)
	 */
	private $dateFrom;
	
	/**
	 * @var date $dateTo
	 *
	 * @ORM\Column(name="date_to", type="datetime", nullable=true)
	 */
	private $dateTo;
	
    /**
     * @var string $note
     *
     * @ORM\Column(name="note", type="string", nullable=true)
     */
    private $note;
    
    /**
     * @var Unit
     *
     * @ORM\ManyToOne(targetEntity="ContractUnit", inversedBy="ranges")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contract_unit_id", referencedColumnName="id")
     * })
     */
    private $contract_unit;
    

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return ContractUnitRanges
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    
        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime 
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     * @return ContractUnitRanges
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    
        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime 
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return ContractUnitRanges
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
     * Set contract_unit
     *
     * @param PHRentals\MainBundle\Entity\ContractUnit $contractUnit
     * @return ContractUnitRanges
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}