<?php 
namespace PHRentals\MainBundle\Helper;

use Doctrine\ORM\EntityManager;

class CalendarHelper {

    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function createDatesForCalendar($data) {
    	
    	$dates=array();
    	 
    	$from = $data['from'];
    	$to = $data['to'];
    	
    	if(isset($from)) {
    		$dates['from'] = new \DateTime($from);
    	}
    	else {
    		$dates['from'] = new \DateTime();
    	}
    	if(isset($to)) {
    		$dates['to'] = new \DateTime($to);
    	}
    	else {
    		$dates['to'] = clone $dates['from'];
    		date_add($dates['to'], date_interval_create_from_date_string('90 days'));
    	}
    	 
    	$dates['today'] = new \DateTime();    // Finds today's date
    	$dates['no_of_days'] = $dates['from']->diff($dates['to'])->format('%a'); // This is to calculate number of days in a month
    	$dates['interval'] = new \DateInterval('P1D');
    	$dates['month'] = clone $dates['from'];
    	$dates['day'] = clone $dates['from'];
    	$dates['day2'] = clone $dates['from'];
    	
    	return $dates;
    }
    
    public function createStays($unitList, \DateTime $dateFrom, \DateTime $dateTo) {

    	$stays = array();
    	$indice_unit = 0;
    	$no_of_days = $dateFrom->diff($dateTo)->format('%a');
    	
    	foreach($unitList as $unit) {
    		 
    		$resas = $this->entityManager->getRepository('PHRentalsMainBundle:Unit')->findReservationsBetweenDates($unit->getId(),$dateFrom->format('Y-m-d'),$dateTo->format('Y-m-d'));
    		 
    		$indice_unit++;
    		$stays[$indice_unit] = array();
    		$stays[$indice_unit]['name'] = $unit->__toString();
    		$stays[$indice_unit]['unit_id'] = $unit->getId();
    		
    		$days_corrected = $no_of_days;
    		 
    		foreach($resas as $resa) {
    	
    			$date1 = $resa->getDateFrom();
    			$date_i = clone $dateFrom;
    			if($date1<$date_i) $date1 = clone $date_i;
    	
    			for($i=1;$i<=$no_of_days;$i++){
    	
    				$indice = $date_i->format('Y-m-d');
    	
    				//print($date_i->format('Y-m-d').'/'.$date1->format('Y-m-d'));
    	
    				if ($date_i->format('Y-m-d')==$date1->format('Y-m-d')) {
    						
    					//nb of nights in period
    						
    					$nights_in_period = $resa->getDateFrom()->diff($resa->getdateTo())->format('%a');
    					if($resa->getDateFrom()<$dateFrom)
    						$nights_in_period = $nights_in_period - $resa->getDateFrom()->diff($dateFrom)->format('%a');
    					if($resa->getdateTo()>$dateTo) {
    						$nights_in_period = $nights_in_period - $dateTo->diff($resa->getdateTo())->format('%a');
    						$days_corrected ++;
    					}
    						
    						
    					$stays[$indice_unit][$indice] = array();
    					$stays[$indice_unit][$indice]['ref'] = $resa->getReservationSet()->getRef();
    					$stays[$indice_unit][$indice]['resa'] = $resa->getId();
    					$stays[$indice_unit][$indice]['id'] = $resa->getReservationSet()->getId();
    					//$stays[$indice_unit][$indice]['customer'] = $resa->getReservationSet()->getCustomer();
    					$stays[$indice_unit][$indice]['datefrom'] = $resa->getDateFrom()->format('Y-m-d');
    					$stays[$indice_unit][$indice]['dateto'] = $resa->getdateTo()->format('Y-m-d');
    					$stays[$indice_unit][$indice]['nights'] = $nights_in_period;
    					$stays[$indice_unit][$indice]['price'] = $resa->getPricePerNight();
    					$stays[$indice_unit][$indice]['status'] = $resa->getReservationSet()->getStatus();
    					$stays[$indice_unit][$indice]['interval'] = new \DateInterval('P'.$nights_in_period.'D');
    					$days_corrected = $days_corrected - $nights_in_period +1;
    				}
    	
    				$date_i->modify('+1 day');
    			}
    		}
    		$stays[$indice_unit]['days_corrected'] = $days_corrected;
    	
    	}
        
    	return $stays;
    }
}