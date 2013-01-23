<?php

namespace PHRentals\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity
 */
class Payment
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
     * @var float $amount
     *
     * @ORM\Column(name="amount", type="float", nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime $date
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string $notes
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;
    
    /**
     * @var ReservationSet
     *
     * @ORM\ManyToOne(targetEntity="ReservationSet", inversedBy="payments", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reservation_set_id", referencedColumnName="id")
     * })
     */
    private $reservationSet;

    /**
     * @var PaymentType
     *
     * @ORM\ManyToOne(targetEntity="PaymentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_type_id", referencedColumnName="id")
     * })
     */
    private $paymentType;

    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->date = new \DateTime('now');
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
     * Set amount
     *
     * @param float $amount
     * @return Payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Payment
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set reservationSet
     *
     * @param PHRentals\MainBundle\Entity\ReservationSet $reservationSet
     * @return Payment
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

    /**
     * Set paymentType
     *
     * @param PHRentals\MainBundle\Entity\PaymentType $paymentType
     * @return Payment
     */
    public function setPaymentType(\PHRentals\MainBundle\Entity\PaymentType $paymentType = null)
    {
        $this->paymentType = $paymentType;
    
        return $this;
    }

    /**
     * Get paymentType
     *
     * @return PHRentals\MainBundle\Entity\PaymentType 
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }
    
    public function __toString()
    {
    	return $this->getDate().' '.$this->getAmount();
    }
    

    /**
     * Set notes
     *
     * @param string $notes
     * @return Payment
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
}