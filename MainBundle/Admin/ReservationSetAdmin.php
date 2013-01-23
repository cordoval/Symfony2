<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

use PHRentals\MainBundle\Entity\ReservationSet as ReservationSetEntity;

class ReservationSetAdmin extends Admin
{
    
    protected $baseRoutePattern = "/reservations";
	
    /**
     * Default Datagrid values
     * 
     * @var array 
     */
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC', 
        '_sort_by' => 'date'
    );
    
	public function getNewInstance()
	{
		$instance = parent::getNewInstance();
		$instance->setRef($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass())->findNextRef());
		return $instance;
	}
	
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
    ->with('General')
      ->add('ref')
      ->add('date', 'date', array('required' => true, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
      ->add('status', 'sonata_type_translatable_choice', array('choices' => ReservationSetEntity::getStatusList(), 'catalogue' => 'SonataOrderBundle'))
      ->add('customer', 'sonata_type_model_list', array('label' => 'Renter', 'required' => false))
      ->add('viaId', 'sonata_type_translatable_choice', array('choices' => ReservationSetEntity::getViaList()))
      ->add('lastCommunication', 'date', array('required' => true, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
      ->add('nbAdults')
      ->add('nbChildren')
      ->add('guestNames')
      ->add('notes')
      ->add('isCancelled')
    ->end()
    ->with('Unit Reservations')
    	->add('reservations','sonata_type_collection', array('label' => 'Add a Unit', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table', 'sortable' => 'position'))
      	->end()
    ->with('Payments')
      	->add('payments','sonata_type_collection', array('label' => 'Add a Payment', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table'))
      	->end()
      ;
      
      if ($this->getSubject()->getId()) {
      	$formMapper
      	->with('Unit Reservations')
      	->add('total', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      	->add('deposit', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      	->end()
      	->with('Dates')
        ->add('modifiedByUser', null, array('label' => 'Modified by', 'disabled' => true))
        ->add('createdByUser', null, array('label' => 'Created by', 'disabled' => true))
      	->add('createdOn', 'datetime', array('disabled' => true, 'widget' => 'single_text', 'format' => 'd-M-y H:m','required'=>false))
      	->add('updatedOn', 'datetime', array('disabled' => true, 'widget' => 'single_text', 'format' => 'd-M-y H:m','required'=>false))
      	->end()
      	;
      } else {
      	$formMapper->setHelps(array(
      			'ref' => $this->trans('This is the last reference registered + 1.')
      	));
      }
      
      
  }
  
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('ref')
      ->add('date', 'doctrine_orm_date_range', array('input_type' => 'timestamp'))
      ->add('status', 'doctrine_orm_choice', array(), 'choice' , array('choices' => ReservationSetEntity::getStatusList()))
      ->add('isCancelled')
      ->add('customer')      
    ;

  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('ref', null, array('route' => array('name' => 'show')))
      ->add('date')
      ->add('status', 'string', array('template' => 'PHRentalsMainBundle:Admin:status.html.twig'))
      //->add('status', 'array', array('choices' => ReservationSetEntity::getStatusList()))
      ->add('customer') 
      ->add('units', 'string', array('template' => 'PHRentalsMainBundle:Admin:reservation_units.html.twig'))
      ->add('isCancelled', null,  array('label' => 'Cancelled'))
      ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )))
    ;
  }
  
  protected function configureShowFields(ShowMapper $filter)
  {
  	$filter
  	->add('ref')
  	->add('date')
  	->add('status')
  	->add('isCancelled')
  	->add('customer')
      ->add('viaId', 'choice', array('choices' => ReservationSetEntity::getViaList(), 'label' => 'Via'))
      ->add('lastCommunication')
      ->add('nbAdults')
      ->add('nbChildren')
      ->add('guestNames')
      ->add('notes')
      ->add('units', 'string', array('template' => 'PHRentalsMainBundle:Admin:reservation_units_show.html.twig'))
      ->add('total')
      ->add('deposit')
      ->add('payments', 'string', array('template' => 'PHRentalsMainBundle:Admin:reservation_payments_show.html.twig'))
      ->add('modifiedByUser')
      ->add('createdByUser')
      ->add('createdOn')
      ->add('updatedOn')
    ->end();
        /*
    ->with('Unit Reservations')
    	->add('reservations','sonata_type_collection', array('label' => 'Add a Unit', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table', 'sortable' => 'position'))
      	->end()
    ->with('Payments')
      	->add('payments','sonata_type_collection', array('label' => 'Add a Payment', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table'))
      	->end() 
  	;*/
  }
  
 
  public function validate(ErrorElement $errorElement, $object)
  {
  	/*
    $errorElement
      ->with('name')
      ->assertMaxLength(array('limit' => 255))
      ->end()
    ;
    
    // conditional validation, see the related section for more information
    if ($object->getBookedByOwner() == '0' && $object->getCustomer() == null) {
    	// abstract cannot be empty when the post is enabled
    	$errorElement
    	->with('bookedByOwner')
    	->addViolation('Either a renter must be defined or booked by owner checked.')
    	->end()
    	;
    	
    }

    if ($object->getStatus() == ReservationSetEntity::STATUS_BOOKED) {
        $errorElement
            ->with('total')
                ->assertNotNull()
            ->with('deposit')
                ->assertNotNull()
            ->end();
    } 
*/
  }
  
  public function whenUpdating($reservationSet)
  {
  	
  	//$reservationSet->setReservations($reservationSet->getReservations());
  	
  $user = $this->configurationPool
  ->getContainer()->get('security.context')->getToken()->getUser();
  $reservationSet->setModifiedByUser($user);
   
  $total = 0;
   
  foreach($reservationSet->getReservations() as $reservation) {
  	
  	$helper = $this->configurationPool->getContainer()->get('phrentals.helper.prices');
  	
  	//nb of nights
  	$night_nb = $reservation->getDateFrom()->diff($reservation->getdateTo())->format('%a');
  	$reservation->setNightNb($night_nb);
  	
  	// get if daily/weekly/1 month/3 month/6 month/1 year
  	
  	if ($night_nb <7) {
  		$length_factor = $reservation->getUnit()->getBaseTo1d()*100;
  		$length_text = "Daily Rate";
  	} elseif ($night_nb <30) {
  		$length_factor = $reservation->getUnit()->getBaseTo1w()*100;
  		$length_text = "Weekly Rate";
  	} elseif ($night_nb <90) {
  		$length_factor = $reservation->getUnit()->getBaseTo1m()*100;
  		$length_text = "Monthly Rate";
  	} elseif ($night_nb <180) {
  		$length_factor = $reservation->getUnit()->getBaseTo3m()*100;
  		$length_text = "3 Month Rate";
  	} elseif ($night_nb <360) {
  		$length_factor = $reservation->getUnit()->getBaseTo6m()*100;
  		$length_text = "6 Month Rate";
  	} else {
  		$length_factor = 0;
  		$length_text = "Yearly Rate";
  	}
  	 
  	// find date in middle of stay
  	$middle = clone $reservation->getDateFrom();
  	$half = intval($night_nb/2);
  	date_add($middle, date_interval_create_from_date_string($half.' days'));
  	
  	// get which season for this date
  	$season = $helper->findSeasonFactor($middle);

	 switch ($season) {
	    case "low":
	        $season_factor = '0';
	        $season_text = "Low Season";
	        break;
	    case "high":
	        $season_factor = $reservation->getUnit()->getHighSeason()*100;
	        $season_text = "High Season";
	        break;
	    case "peak":
	        $season_factor = $reservation->getUnit()->getPeakSeason()*100;
	        $season_text = "Peak Season";
	        break;
	}
	
  	$reservation->setPricePerNight(round($reservation->getUnit()->getBaseRate()*(($season_factor+100)/100)*(($length_factor+100)/100)/100)*100);
  	$reservation->setPriceRate($season_text." - ".$length_text);
  	
  	//$reservation->setNightNb((strtotime($reservation->getDateTo()->format('Y-m-d')) - strtotime($reservation->getDateFrom()->format('Y-m-d')))/86400);
  	$reservation->setTotalCalculated($reservation->getPricePerNight()*$reservation->getNightNb());
  	if ($reservation->getTotal() == null) {
  		$reservation->setTotal($reservation->getTotalCalculated());
  	}
  	$total += $reservation->getTotal();
  }
  $reservationSet->setTotal($total);
  $reservationSet->setDeposit($helper->findDeposit($total));
}
  
  public function prePersist($reservationSet)
  {
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $reservationSet->setCreatedByUser($user);
  	$this->whenUpdating($reservationSet);
  }
  
  public function preUpdate($reservationSet)
  {
  	$this->whenUpdating($reservationSet);
  }
  
}