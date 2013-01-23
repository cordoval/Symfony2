<?php
namespace PHRentals\MainBundle\Validator;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ReservedAlreadyValidator extends ConstraintValidator
{  
	
	private $entityManager;
	
	public function __construct( $entityManager)
	{
		$this->entityManager = $entityManager;
	}
	

    public function validate($reservationSet, Constraint $constraint)
    {
    	
    	// Either a renter must be defined or booked by owner checked.
    	if ($reservationSet->getStatus() != '4' && $reservationSet->getCustomer() == null) {
    		//$this->context->addViolationAtSubPath('status', null , array(), null);
    		$this->context->addViolationAtSubPath('customer', 'Either a renter must be defined or booked by owner checked.' , array(), null);
    	}
    	// Reservation cannot be at the same time booked by owner and by renter.
    	if ($reservationSet->getStatus() == '4' && $reservationSet->getCustomer() != null) {
    		//$this->context->addViolationAtSubPath('status', null , array(), null);
    		$this->context->addViolationAtSubPath('customer', 'Reservation cannot be at the same time booked by owner and by renter.' , array(), null);
    	}
    	
    	foreach($reservationSet->getReservations() as $reservation) {
    	
    		// Check reservation dates.
	    	if ($reservation->getDateFrom()->format('Y-m-d') >= $reservation->getDateTo()->format('Y-m-d')) {
	    		$this->context->addViolationAtSubPath('reservation', 'Check reservation dates. Departure Date ('.$reservation->getDateTo()->format('Y-m-d').') must be after arrival date ('.$reservation->getDateFrom()->format('Y-m-d').').' , array(), null);
	    	}
	    	
	    	
	    	// Check if no reservation already on this dates and unit  		
	    		$qb = $this->entityManager->createQueryBuilder();
	    		
	    		$query = $qb->select('u')
	    		->from('PHRentalsMainBundle:Reservation', 'u')
	    		->where('u.unit = :unit AND ((u.dateFrom <= :from AND u.dateTo > :to) OR (u.dateFrom < :from AND u.dateTo >= :to) OR (u.dateFrom >= :from AND u.dateTo <= :to))')
	    		->setParameter('unit', $reservation->getUnit()->getId())
	    		->setParameter('from', $reservation->getDateFrom()->format('Y-m-d'))
	    		->setParameter('to', $reservation->getDateTo()->format('Y-m-d'));
	    		
	    		if ($reservation->getId() > 0) {
	    			$query = $qb->andWhere('u.id <> :id')
	    			->setParameter('id', $reservation->getId());
	    		}
	    		
	    		/*
	    		echo '<pre>'.$qb->getQuery()->getSql();
	    		echo $reservation->getUnit()->getId();
	    		echo $reservation->getDateFrom()->format('Y-m-d');
	    		echo $reservation->getDateTo()->format('Y-m-d');
	    		die;
	    		*/
	    		
	    		if ($result = $qb->getQuery()->getResult())
	    		{
	    			$existing = $result[0];
	    		
	    			// throw an error bound to the datefrom field
	    		$this->context->addViolationAtSubPath('reservation', 'The bungalow selected is already <a href= target=blank>occupied</a> from '. $existing->getDateFrom()->format('Y-m-d') .' to '.$existing->getDateTo()->format('Y-m-d') , array(), null);
	    		}
    	}
    	
    }
    
}