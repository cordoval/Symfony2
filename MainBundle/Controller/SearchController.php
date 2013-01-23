<?php
namespace PHRentals\MainBundle\Controller;

use PHRentals\MainBundle\Entity\Contract;
use PHRentals\MainBundle\Entity\ContractUnit;
use PHRentals\MainBundle\Entity\Unit;
use PHRentals\MainBundle\Entity\Address;
use PHRentals\MainBundle\Entity\Contact;
use PHRentals\MainBundle\Entity\Project;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Locale\Locale;

class SearchController extends Controller
{
   
    public function unitsAction() {
    	
    	global $search_string;

    	$search_string = '';
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	//$this->get('session')->setFlash('sonata_flash_success', sprintf('Still not implemented!.'));
    	
    	$search_type = $this->get('request')->request->get('search');
    	
    	// CONTACT SEARCH
    	
    	$contact_results = $this->get('request')->request->get('contactform');
    	
    	$search = 0;
    	
    	$contacts = "";
    	 
    	if ($this->get('request')->getMethod() == 'POST' && $search_type == 'contact') {
    		//if ($results) {
    	
    		$results = array_map('trim', $contact_results);
    	
    		$contacts = $em->getRepository('PHRentalsMainBundle:Contact')->findContacts($contact_results);
    	
    		$search = 1;
    		
    		// dates for calendar
    		 
    		$dates['from'] = new \DateTime();
    		$dates['to'] = clone $dates['from'];
    		date_add($dates['to'], date_interval_create_from_date_string('90 days'));
    		$dates['today'] = new \DateTime();    // Finds today's date
    		$dates['no_of_days'] = $dates['from']->diff($dates['to'])->format('%a'); // This is to calculate number of days in a month
    		$dates['interval'] = new \DateInterval('P1D');
    		$dates['month'] = clone $dates['from'];
    		$dates['day'] = clone $dates['from'];
    		$dates['day2'] = clone $dates['from'];
    		
    	return $this->render('PHRentalsMainBundle:Admin:contact-search-2.html.twig', array(
    			'action'   => 'search',
    			'object'   => $contacts,
    			'search' => $search,
    			'dates' => $dates
    	));
    	}
    	
    	// UNIT SEARCH
    	
    	$units = "";
    	$defaultData = array();
    	$results = $this->get('request')->request->get('form');
    	
    	//print_r($results);
    	
    	if ($this->get('request')->getMethod() == 'POST'  && $search_type == 'unit') {
    		
    			//$results = array_map('trim', $results);
    			
    			$units = $em->getRepository('PHRentalsMainBundle:Unit')->findUnits($results);
    		   	
    			
    		
    			//$reservation->getDateFrom()->format('Y-m-d')

    		
    		/*
    		$defaultData = array(
    				'reference' => trim($results['reference']),
    				'refentity' => (isset($results['refentity'])? $results['active']: ''),
    				'keyword' => trim($results['keyword']),
    				'active' => (isset($results['active'])? $results['active']: '') ,
    				'inactive' => (isset($results['inactive'])? $results['active']: ''),
    				'unitClass' => (isset($results['unitClass'])? $results['active']: ''),
    				'area_living_from' => $results['area_living_from'],
    				'area_living_to' => $results['area_living_to'],
    				'area_land_from' => $results['area_land_from'],
    				'area_land_to' => $results['area_land_to'],
    		);
    		*/
    	}
    	
    	// dates for calendar
    	
    	$dates['from'] = new \DateTime();
    	$dates['to'] = clone $dates['from'];
    	date_add($dates['to'], date_interval_create_from_date_string('90 days'));
    	$dates['today'] = new \DateTime();    // Finds today's date
    	$dates['no_of_days'] = $dates['from']->diff($dates['to'])->format('%a'); // This is to calculate number of days in a month
    	$dates['interval'] = new \DateInterval('P1D');
    	$dates['month'] = clone $dates['from'];
    	$dates['day'] = clone $dates['from'];
    	$dates['day2'] = clone $dates['from'];
    	
    	$unitClasses = array();
    	foreach($em->getRepository('PHRentalsMainBundle:UnitClass')->findAll() as $unitClass) {
    		$unitClasses[$unitClass->getId()] = $unitClass->getName();
    	}
    	 
    	$unitSizes = array();
    	foreach($em->getRepository('PHRentalsMainBundle:UnitSize')->findAll() as $unitSize) {
    		$unitSizes[$unitSize->getId()] = $unitSize->getName();
    	}
    	
    	$unitTags = array();
    	foreach($em->getRepository('PHRentalsMainBundle:UnitTag')->findBy(array(), array('group' => 'asc', 'position' => 'asc')) as $unitTag) {
    		$unitTags[$unitTag->getId()] = $unitTag->getName();
    	}
    	
    	$addressTags = array();
    	foreach($em->getRepository('PHRentalsMainBundle:AddressTag')->findBy(array(), array('group' => 'asc', 'position' => 'asc')) as $addressTag) {
    		$addressTags[$addressTag->getId()] = $addressTag->getName();
    	}
    	 
    	$locations = array();
    	foreach($em->getRepository('PHRentalsMainBundle:Location')->findAll() as $location) {
    		$locations[$location->getId()] = $location->getName();
    	}
    	$districts = array();
    	foreach($em->getRepository('PHRentalsMainBundle:District')->findAll() as $district) {
    		$districts[$district->getId()]['name'] = $district->getName();
    		$districts[$district->getId()]['class'] = $district->getLocation()->getId();
    	}
    	
    	$users = array();
    	foreach($em->getRepository('ApplicationSonataUserBundle:User')->findAll() as $user) {
    		$users[$user->getId()] = $user->getUsername();
    	}
    	
	    	$form = $this->createFormBuilder(null, array('csrf_protection' => false))
	    	->add('unitTags', 'choice', array('required' => false, 'expanded'=>true, 'multiple' =>true,'choices' => $unitTags))
	    	->add('addressTags', 'choice', array('required' => false, 'expanded'=>true, 'multiple' =>true,'choices' => $addressTags))
	    	->add('users', 'choice', array('required' => false, 'expanded'=>false, 'multiple' =>false,'choices' => $users))
	    	->getForm();
	    	
	    // display editable notes
	    	$file = "notes.txt";
	    	$open = fopen($file, 'rb');
	    	$notes['text'] = stream_get_contents($open);
	    	$notes['hash'] = sha1_file($file);
	    	//fwrite($open, $content);
	    	fclose($open);
    	 
    	return $this->render('PHRentalsMainBundle:Admin:unit-search.html.twig', array(
    			'action'   => 'search',
    			'form' => $form->createView(),
    			'locations'=> $locations,
    			'districts' => $districts,
    			'results' => $results,
    			'contact_results' => $contact_results,
    			'units' => $units,
    			'contacts' => $contacts,
    			'search' => $search_string,
    			'dates' => $dates,
    			'notes' => $notes
    	));
    
    }
    
    
}
?>

