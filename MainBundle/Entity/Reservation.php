<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */

//@ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")

class Reservation
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
     * @var \DateTime $dateFrom
     *
     * @ORM\Column(name="date_from", type="date", nullable=false)
     */
    private $dateFrom;

    /**
     * @var \DateTime $dateTo
     *
     * @ORM\Column(name="date_to", type="date", nullable=false)
     */
    private $dateTo;

    /**
     * @var integer $pricePerNight
     *
     * @ORM\Column(name="price_per_night", type="integer", nullable=true)
     */
    private $pricePerNight;
    
    /**
     * @var integer $priceRate
     *
     * @ORM\Column(name="price_rate", type="string", length=255, nullable=true)
     */
    private $priceRate;
    
    /**
     * @var integer $nightNb
     *
     * @ORM\Column(name="night_nb", type="integer", nullable=true)
     */
    private $nightNb;
    
    /**
     * @var integer $totalCalculated
     *
     * @ORM\Column(name="total_calculated", type="integer", nullable=true)
     */
    private $totalCalculated;
    
    /**
     * @var integer $total
     *
     * @ORM\Column(name="total", type="integer", nullable=true)
     */
    private $total;

    /**
     * @var Unit
     *
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="reservations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     * })
     */
    private $unit;

    /**
     * @var ReservationSet
     *
     * @ORM\ManyToOne(targetEntity="ReservationSet", inversedBy="reservations", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reservation_set_id", referencedColumnName="id")
     * })
     */
    private $reservationSet;

    /**
     * @var position
     * 
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;
    
    //@Gedmo\SortablePosition

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
    	$this->dateFrom = new \DateTime('now');
    	$this->dateTo = new \DateTime('now');
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
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return Reservation
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
     * @return Reservation
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
     * Set pricePerNight
     *
     * @param integer $pricePerNight
     * @return Reservation
     */
    public function setPricePerNight($pricePerNight)
    {
        $this->pricePerNight = $pricePerNight;
    
        return $this;
    }

    /**
     * Get pricePerNight
     *
     * @return integer 
     */
    public function getPricePerNight()
    {
        return $this->pricePerNight;
    }

    /**
     * Set priceRate
     *
     * @param integer $priceRate
     * @return Reservation
     */
    public function setPriceRate($priceRate)
    {
    	$this->priceRate = $priceRate;
    
    	return $this;
    }
    
    /**
     * Get priceRate
     *
     * @return integer
     */
    public function getPriceRate()
    {
    	return $this->priceRate;
    }    
    
    /**
     * Set unit
     *
     * @param PHRentals\MainBundle\Entity\Unit $unit
     * @return Reservation
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
     * Set reservationSet
     *
     * @param PHRentals\MainBundle\Entity\ReservationSet $reservationSet
     * @return Reservation
     */
    public function setReservationSet(\PHRentals\MainBundle\Entity\ReservationSet $reservationSet = null)
    {
        $this->reservationSet = $reservationSet;
    
        return $this;
    }

    /**
     * Get reservationSet
     *
     * @return PHRentals\MainBundle\Entity\ReservationSet 
     */
    public function getReservationSet()
    {
        return $this->reservationSet;
    }
    
    public function getCreatedAt()
    {
    	return $this->createdAt;
    }
    
    public function getUpdatedAt()
    {
    	return $this->updatedAt;
    }
    
    public function __toString()
    {
    	return $this->getUnit()->getName().' Reservation';
    }
    
    /**
     * Set position
     *
     * @param integer $position
     * @return Reservation
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Reservation
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
     * @return Reservation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Reservation
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    } 
    

    /**
     * Set nightNb
     *
     * @param integer $nightNb
     * @return Reservation
     */
    public function setNightNb($nightNb)
    {
        $this->nightNb = $nightNb;
    
        return $this;
    }

    /**
     * Get nightNb
     *
     * @return integer 
     */
    public function getNightNb()
    {
        return $this->nightNb;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return Reservation
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set totalCalculated
     *
     * @param integer $totalCalculated
     * @return Reservation
     */
    public function setTotalCalculated($totalCalculated)
    {
        $this->totalCalculated = $totalCalculated;
    
        return $this;
    }

    /**
     * Get totalCalculated
     *
     * @return integer 
     */
    public function getTotalCalculated()
    {
        return $this->totalCalculated;
    }
}