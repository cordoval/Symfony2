<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use PHRentals\MainBundle\Validator\Constraints as CustomAssert;

/**
 * PHRentals\MainBundle\Entity\ReservationSet
 *
 * @ORM\Table(name="reservation_set")
 * @ORM\Entity(repositoryClass="PHRentals\MainBundle\Repository\ReservationSetRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @UniqueEntity(fields={"ref"}, message="Reference is already used.")
 * @CustomAssert\ReservedAlready
 * 
 */
class ReservationSet
{
    const STATUS_OFFER = 1;
    const STATUS_PENDING = 2;
    const STATUS_BOOKED   = 3;
    const STATUS_OWNER   = 4;
    
    const VIA_EMAIL = 1;
    const VIA_SMS = 2;
    const VIA_CALL   = 3;
    const VIA_WALKIN   = 4;
	
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $ref
     *
     * @ORM\Column(name="ref", type="string", length=127, nullable=false, unique=true)
     */
    private $ref;
    
    /**
     * @var \DateTime $date
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     * @Gedmo\Versioned
     */
    private $date;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=127, nullable=false)
     * @Gedmo\Versioned
     */
    private $status;

    /**
     * @var \DateTime $lastCommunication
     *
     * @ORM\Column(name="last_communication", type="date", nullable=true)
     */
    private $lastCommunication;

    /**
     * @var boolean $isCancelled
     *
     * @ORM\Column(name="is_cancelled", type="boolean", nullable=true)
     */
    private $isCancelled;

    /**
     * @var string $viaId
     *
     * @ORM\Column(name="via_id", type="string", length=127, nullable=true)
     */
    private $viaId;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;
    
    /**
     * @var string $nbAdults
     *
     * @ORM\Column(name="adults_nb", type="integer", nullable=true)
     */
    private $nbAdults;
    
    /**
     * @var string $nbChildren
     *
     * @ORM\Column(name="children_nb", type="integer", nullable=true)
     */
    private $nbChildren;
    
    /**
     * @var string $guestNames
     *
     * @ORM\Column(name="guest_names", type="text", nullable=true)
     */
    private $guestNames;
    
    /**
    * @var string $notes
    *
    * @ORM\Column(name="notes", type="text", nullable=true)
    */
    
    private $notes;
    
    /**
     * @var ArrayCollection $reservations
     *
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="reservationSet", cascade={"all"}, orphanRemoval=true)
     */
    private $reservations;
    
    /**
     * @var ArrayCollection $payments
     *
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="reservationSet", cascade={"all"}, orphanRemoval=true)
     */
    private $payments;
    
    /**
     * @var string $total
     *
     * @ORM\Column(name="total", type="integer", nullable=true)
     */
    private $total;
    
    /**
     * @var string $deposit
     *
     * @ORM\Column(name="deposit", type="integer", nullable=true)
     */
    private $deposit;

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
     *   @ORM\JoinColumn(name="modifiedByUser", referencedColumnName="id")
     * })
     */
    private $modifiedByUser;
    
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
     * Set date
     *
     * @param \DateTime $date
     * @return ReservationSet
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
     * Set status
     *
     * @param string $status
     * @return ReservationSet
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

    public static function getStatusList()
    {
    	return array(
    			self::STATUS_OFFER => 'Offer',
    			self::STATUS_PENDING => 'Pending Payment',
    			self::STATUS_BOOKED   => 'Booked',
    			self::STATUS_OWNER   => 'Booked by Owner',
    	);
    }
    
    public function getStatusName()
    {
        $statuses = $this->getStatusList();
        return $statuses[$this->status];
    }
    

    /**
     * Set lastCommunication
     *
     * @param \DateTime $lastCommunication
     * @return ReservationSet
     */
    public function setLastCommunication($lastCommunication)
    {
        $this->lastCommunication = $lastCommunication;
    
        return $this;
    }

    /**
     * Get lastCommunication
     *
     * @return \DateTime 
     */
    public function getLastCommunication()
    {
        return $this->lastCommunication;
    }

    /**
     * Set isCancelled
     *
     * @param boolean $isCancelled
     * @return ReservationSet
     */
    public function setIsCancelled($isCancelled)
    {
        $this->isCancelled = $isCancelled;
    
        return $this;
    }

    /**
     * Get isCancelled
     *
     * @return boolean 
     */
    public function getIsCancelled()
    {
        return $this->isCancelled;
    }

    /**
     * Set viaId
     *
     * @param string $viaId
     * @return ReservationSet
     */
    public function setViaId($viaId)
    {
        $this->viaId = $viaId;
    
        return $this;
    }

    /**
     * Get viaId
     *
     * @return string 
     */
    public function getViaId()
    {
        return $this->viaId;
    }
    
    public static function getViaList()
    {
    	return array(
    			self::VIA_EMAIL => 'Email',
    			self::VIA_SMS => 'SMS',
    			self::VIA_CALL   => 'Call',
    			self::VIA_WALKIN   => 'Walk-In',
    	);
    }
    
    public function getViaName()
    {
    	$via_list = $this->getViaList();
    	return $via_list[$this->viaId];
    }

    /**
     * Set customer
     *
     * @param PHRentals\MainBundle\Entity\Customer $customer
     * @return ReservationSet
     */
    public function setCustomer(\PHRentals\MainBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;
    
        return $this;
    }

    /**
     * Get customer
     *
     * @return PHRentals\MainBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
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
    	return $this->getRef();
    }
    
    /*
    public function updateReservationSet(User $user)
    {
    	$this->modifiedByUser = $user->getId();
    }
    */
    


    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return ReservationSet
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
     * Set modifiedByUser
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return ReservationSet
     */
    public function setModifiedByUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->modifiedByUser = $user;
    
        return $this;
    }

    /**
     * Get modifiedByUser
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getModifiedByUser()
    {
        return $this->modifiedByUser;
    }
    
    /**
     * Set createdByUser
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return ReservationSet
     */
    public function setCreatedByUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->createdByUser = $user;
    
        return $this;
    }

    /**
     * Get createdByUser
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getCreatedByUser()
    {
        return $this->createdByUser;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ReservationSet
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
     * @return ReservationSet
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->payments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime('now');
        $this->lastCommunication = new \DateTime('now');
        //$this->ref = $em->getRepository('PHRentalsMainBundle:ReservationSet')->findNextRef();
    }
    
    /**
     * Add reservations
     *
     * @param PHRentals\MainBundle\Entity\Reservation $reservations
     * @return ReservationSet
     */
    public function addReservation(\PHRentals\MainBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;
        $reservations->setReservationSet($this);
    
        return $this;
    }
    
    public function addReservations(\PHRentals\MainBundle\Entity\Reservation $reservations)
    {
    	$this->reservations[] = $reservations;
    	$reservations->setReservationSet($this);
    
    	return $this;
    }

    /**
     * Remove reservations
     *
     * @param PHRentals\MainBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\PHRentals\MainBundle\Entity\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
        $reservation->setReservationSet(null);
    }
    
    public function removeReservations(\PHRentals\MainBundle\Entity\Reservation $reservation)
    {
    	$this->reservations->removeElement($reservation);
        //$reservations->setReservationSet(null);
    }

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
     * Set reservations
     *
     */
    public function setReservations($reservations)
    {
    	foreach ($this->reservations as $reservation) {
    		if ($reservations->contains($reservation)) {
    			$reservations->removeElement($reservation);
    		} else {
    			$this->removeReservation($reservation);
    		}
    	}
    
    	foreach ($reservations as $reservation) {
    		$this->addReservation($reservation);
    	}
    }
    
    /**
     * Set ref
     *
     * @param string $ref
     * @return ReservationSet
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    
        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set nbAdults
     *
     * @param integer $nbAdults
     * @return ReservationSet
     */
    public function setNbAdults($nbAdults)
    {
        $this->nbAdults = $nbAdults;
    
        return $this;
    }

    /**
     * Get nbAdults
     *
     * @return integer 
     */
    public function getNbAdults()
    {
        return $this->nbAdults;
    }

    /**
     * Set nbChildren
     *
     * @param integer $nbChildren
     * @return ReservationSet
     */
    public function setNbChildren($nbChildren)
    {
        $this->nbChildren = $nbChildren;
    
        return $this;
    }

    /**
     * Get nbChildren
     *
     * @return integer 
     */
    public function getNbChildren()
    {
        return $this->nbChildren;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return ReservationSet
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
     * Set deposit
     *
     * @param integer $deposit
     * @return ReservationSet
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
     * Add payments
     *
     * @param PHRentals\MainBundle\Entity\Payment $payments
     * @return ReservationSet
     */
    public function addPayment(\PHRentals\MainBundle\Entity\Payment $payments)
    {
        $this->payments[] = $payments;
        $payments->setReservationSet($this);
    
        return $this;
    }
    
    public function addPayments(\PHRentals\MainBundle\Entity\Payment $payment)
    {
    	$this->payments[] = $payment;
    	$payment->setReservationSet($this);
    
    	return $this;
    }

    /**
     * Remove payments
     *
     * @param PHRentals\MainBundle\Entity\Payment $payments
     */
    public function removePayment(\PHRentals\MainBundle\Entity\Payment $payments)
    {
        $this->payments->removeElement($payments);
        $payments->setReservationSet(null);
    }
    
    public function removePayments(\PHRentals\MainBundle\Entity\Payment $payment)
    {
    	$this->payments->removeElement($payment);
        $payment->setReservationSet(null);
    }

    /**
     * Get payments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPayments()
    {
        return $this->payments;
    }
    
    /**
     * Set notes
     *
     * @param string $notes
     * @return ReservationSet
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
     * Set guestNames
     *
     * @param string $guestNames
     * @return ReservationSet
     */
    public function setGuestNames($guestNames)
    {
        $this->guestNames = $guestNames;
    
        return $this;
    }

    /**
     * Get guestNames
     *
     * @return string 
     */
    public function getGuestNames()
    {
        return $this->guestNames;
    }
}