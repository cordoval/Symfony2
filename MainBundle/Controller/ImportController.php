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

class ImportController extends Controller
{
   
    public function importlistingAction() {
    	
    	function br2nl( $input ) {
    		return preg_replace('/<br(\s+)?\/?>/i', "\n", $input);
    	}
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	$results = $this->get('request')->request->get('form');
    	
    	$display = null;
    	   	
    	//$headers = "Active	Ref #	K. Ref#	O. Ref#	ppb id	Class	Unit	Building name/number	Purpose	Unit Type	Bed	Bath	Floor	View	Living Area Size (Sqm)	Land Size (Sqm.)	Keys At	Remarks	Responsive	Featured	Furnished	A/C	Kitchen	Cooking Hob	Microwave	Fridge	Tv	Safe	Internet	Ownership	Sale Price	Rental Long Term	Rental Short Term	Rental Weekly	Rental Daily	Project	Description";
    	//$headers = "Active	P.ref	K.ref	O.Ref# (owner ID)	ppb id	Class	Unit	Purpose	Unit Type	Bed	Bath	Floor	Sea view	Living Area (sqm)	Land Size (sqm)	Keys At	Remarks	Responsive	Featured	Furnished	A/C	Kitchen	Cooking Hob	Microwave	Fridge	Tv	Safe	Internet	Ownership	Commission	Sale Price	Rental Long Term (Baht/Month)	Rental Short Term (Baht/Month)	Rental Weekly (Baht/Day)	Rental Daily (Baht/Day)	Project (website title)	Description	Rental Available from";
    	$headers = "P-Ref	K-Ref	O-id	Class	PPB-id	District(simple)	Dist.Beach(m)	Standalone.Addr.	Unit#/Build.	Unit.note	Unit.Type	Beds	Bath	Floor/Storey	Living(m2)	Land(m2)	View	Furnished	A/C	Kitchen	Cooking	Microwave	Fridge	TV	Safe	Internet	Tags	Purpose	Ownership	Sale.Price	Negotiable	Comm(%)	Comm.note	Rent-1y	Rent-6m	Rent-3m	H.Rent.mo	H.Rent.week	H.Rent.day	Electric	Water	Cleaning	WiFi	Available	Keys.At	In.K	K.Status	K.Status.Note	Origin	K.date	K.Note	Web.Active	Webtitle	Web.Featured	Listing.Desc";
    	
    	$defaultData = array('listing' => $headers);
    	
    	$form = $this->createFormBuilder($defaultData, array('csrf_protection' => false))
    	->add('listing', 'textarea', array('required' => true, 'label' => 'Import'))
    	//->add('excel', 'file', array('required' => true, 'label' => 'File'))
    	->getForm();
    	
    	$error_log = "";
    	$error = false;
    	
    	$notice_log = "";
    	
    	if ($this->get('request')->getMethod() == 'POST') {

    		
    		$defaultData = array('listing' => $results['listing']);

    		$splitlines = explode("\n", $results['listing']);
    		
    		$i=0;
    		
    		$helper = $this->container->get('phrentals.helper.prices');
    		
    		foreach ($splitlines as $line) {
    					
    			
    			if(trim($line) != trim($headers) && $line != "") {
    			
    				$i++;
	    			$display .= $i.' '.$line.'<br>';
	    			
	    			
	    			$data = array();
	    			$line_array = explode("	", $line);
	    			
	    			if(count($line_array) != 55) {
	    				$error_log .= 'Line '.$i.': Wrong format of imported line.<br/>';
	    				$error = true;
	    			}
	    			else {
	    			
		    			list($data['P-Ref'], $data['K-Ref'], $data['O-id'], $data['Class'], $data['PPB-id'], $data['District(simple)'], $data['Dist.Beach(m)'], $data['Standalone.Addr.'], $data['Unit#/Build.'], $data['Unit.note'], $data['Unit.Type'], $data['Beds'], $data['Bath'], $data['Floor/Storey'], $data['Living(m2)'], $data['Land(m2)'], $data['View'], $data['Furnished'], $data['A/C'], $data['Kitchen'], $data['Cooking'], $data['Microwave'], $data['Fridge'], $data['TV'], $data['Safe'], $data['Internet'], $data['Tags'], $data['Purpose'], $data['Ownership'], $data['Sale.Price'], $data['Negotiable'], $data['Comm(%)'], $data['Comm.note'], $data['Rent-1y'], $data['Rent-6m'], $data['Rent-3m'], $data['H.Rent.mo'], $data['H.Rent.week'], $data['H.Rent.day'], $data['Electric'], $data['Water'], $data['Cleaning'], $data['WiFi'], $data['Available'], $data['Keys.At'], $data['In.K'], $data['K.Status'], $data['K.Status.Note'], $data['Origin'], $data['K.date'], $data['K.Note'], $data['Web.Active'], $data['Webtitle'], $data['Web.Featured'], $data['Listing.Desc']) = explode("	", $line);
		    					
		    			$data = array_map('trim', $data);
		    			
		    			foreach ($data as $element) {
		    				$display .= $element.'/';
		    			}
		    			
		    			$display .= '<br>';
		    			
		    			$owner = $em->getRepository('PHRentalsMainBundle:Contact')->find($data['O-id']);

		    			if(!$owner) {
		    				$error_log .= 'Line '.$i.': Owner with ID '.$data['O-id'].' doesn\'t exist!<br/>';
		    				$error = true;
		    			} else {
		    				$notice_log .= 'Line '.$i.': Owner with ID '.$data['O-id'].' is '.$owner->getName().'.<br/>';
		    			}
		    			
		    			$unit = $em->getRepository('PHRentalsMainBundle:Unit')->findOneBy(array('pRef' => $data['P-Ref']));
		    			if($unit && $data['P-Ref']>0) {
		    				$notice_log .= 'Line '.$i.': A unit with P-Ref #'.$data['P-Ref'].' already exists : UPDATE<br/>';
		    				$update = true;
		    			} else {
		    				$update = false;
		    				$unit = new Unit;
		    				
		    				if($data['P-Ref']) {
		    					$unit->setPRef($data['P-Ref']);
		    					$notice_log .= 'Line '.$i.': New unit with P-Ref #'.$data['P-Ref'].' created.<br/>';
		    				} else {
		    					$nextref = $this->container->get('doctrine')->getRepository('PHRentalsMainBundle:Unit')->findNextRef();
		    					$unit->setPRef($nextref);
		    					$notice_log .= 'Line '.$i.': New unit with P-Ref #'.$nextref.' created.<br/>';
		    				}
		    				
		    				// no PPB, create address
		    				if(!$data['PPB-id']) {
		    					if($data['District(simple)'] && $data['Standalone.Addr.']) {
		    				
		    						$address = new Address();
		    						if($data['Standalone.Addr.']) $address->setText($data['Standalone.Addr.']);
		    						if($data['Dist.Beach(m)']>0) $address->setDistanceToBeach($data['Dist.Beach(m)']);
		    						$address->setClass($em->getRepository('PHRentalsMainBundle:AddressClass')->findOneBy(array('name' => 'Standalone')));
		    				
		    						$district = $em->getRepository('PHRentalsMainBundle:District')->findOneBy(array('name' => $data['District(simple)']));
		    						if ($district) {
		    							$address->setDistrict($district);
		    						} else {
		    							$error_log .= 'Line '.$i.': District '.$data['District(simple)'].' not found.<br/>';
		    							$error = true;
		    						}
		    						$unit->setAddress($address);
		    						$em->persist($address);
		    				
		    					} else {
		    						$error_log .= 'Line '.$i.': If standalone unit, you must indicate address and simplified district.<br/>';
		    						$error = true;
		    					}
		    					 
		    				}
		    			}
		    			
		    			if(!$error) {
		    				
			    			//$unit->setPRef($data['P-Ref']);
			    			if($data['Unit#/Build.']) $unit->setNum($data['Unit#/Build.']);
			    			if($data['Listing.Desc']) $unit->setDescription(br2nl($data['Listing.Desc']));
			    			if($data['Unit.note']) $unit->setRemarks(br2nl($data['Unit.note']));
			    			
			    			if($data['Web.Active'] == 'Yes') $unit->setActive(true);
			    			if($data['Web.Active'] == 'No') $unit->setActive(false);
			    			
			    			$class = $em->getRepository('PHRentalsMainBundle:UnitClass')->findOneBy(array('name' => $data['Class']));
			    			if ($class) {
			    				$unit->setClass($class);
			    			} else {
			    				$error = true;
			    				$error_log .= 'Line '.$i.': Class incorrect.<br/>';
			    			}
			    			
			    			$unit->setOwner($owner);
			    			
			    			if($data['Web.Featured'] == 'Yes') $unit->setFeatured(true);
			    			
			    			if($data['PPB-id']) {
				    			$project = $em->getRepository('PHRentalsMainBundle:Project')->find($data['PPB-id']);
				    			if(!$project) {
				    				$error_log .= 'Line '.$i.': Project with id '.$data['PPB-id'].' doesn\'t exist!<br/>';
				    				$error = true;
				    			} else {
				    				$unit->setProject($project);
				    				$notice_log .= 'Line '.$i.': Project with PPB id '.$data['PPB-id'].' is '.$project->getName().'.<br/>';
				    			}
			    			} else {
			    				if($data['District(simple)'] && $data['Standalone.Addr.']) {
			    					
			    					$address = $unit->getAddress();
			    					if($address) {
					    				if($data['Standalone.Addr.']) $address->setText($data['Standalone.Addr.']);
		    							if($data['Dist.Beach(m)']>0) $address->setDistanceToBeach($data['Dist.Beach(m)']);
					    				$address->setClass($em->getRepository('PHRentalsMainBundle:AddressClass')->findOneBy(array('name' => 'Standalone')));
					    				
					    				$district = $em->getRepository('PHRentalsMainBundle:District')->findOneBy(array('name' => $data['District(simple)']));
					    				if ($district) {
					    					$address->setDistrict($district);
					    				} else {
					    					$error_log .= 'Line '.$i.': District '.$data['District(simple)'].' not found.<br/>';
					    					$error = true;
					    				}
					    				$em->persist($address);
			    					}
				    				
			    				}
			    			}
			    			
			    			// only update slug if empty
			    			if(!$unit->getSlug()) {
			    				$unit->setSlug($em->getRepository('PHRentalsMainBundle:Unit')->createSlug($unit));
			    			}
			    			
			    			if($data['Webtitle']) $unit->setWebTitle($data['Webtitle']);

			    			if(in_array($data['Ownership'], Unit::getOwnershipList())) {
			    				$unit->setOwnership($data['Ownership']);
			    			}
			    			
			    			if($data['Living(m2)']) $unit->setLivingArea($data['Living(m2)']);
			    			
			    			if($data['Land(m2)']) $unit->setLandSize($data['Land(m2)']);
			    			
			    			if($data['Floor/Storey']) $unit->setFloor($data['Floor/Storey']);
			    			
			    			if($data['Beds']) $unit->setBedrooms($data['Beds']);
			    			
			    			if ($data['Unit.Type'] == $unit->getBedrooms().' bedroom'.($unit->getBedrooms()>1?'s':'')) {
			    				$data['Unit.Type'] = '# bedroom(s)';
			    			}
			    			$unitType = $em->getRepository('PHRentalsMainBundle:UnitSize')->findOneBy(array('name' => $data['Unit.Type']));
			    			if($unitType) {
			    				$unit->setUnitType($unitType);
			    			}
			    			
			    			if($data['Bath'])  $unit->setBathrooms($data['Bath']);
			    			
			    			if($data['Furnished']) {
				    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => $data['Furnished']));
				    			if($tag) {
				    				$unit->addTag($tag);
				    			}
			    			}
			    			if($data['View']) {
				    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => $data['View']));
				    			if($tag) {
				    				$unit->addTag($tag);
				    			}
			    			}
			    			if($data['Kitchen']) {
			    				$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => 'kitchen'));
			    				if($tag) {
			    					$unit->addTag($tag);
			    				}
			    			}
			    			if($data['Cooking']) {
			    				$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => 'cooking hob'));
			    				if($tag) {
			    					$unit->addTag($tag);
			    				}
			    			}
			    			if($data['Microwave']) {
			    				$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => 'microwave'));
			    				if($tag) {
			    					$unit->addTag($tag);
			    				}
			    			}
			    			if($data['Fridge']) {
			    				$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => 'fridge'));
			    				if($tag) {
			    					$unit->addTag($tag);
			    				}
			    			}
			    			if($data['TV']) {
			    				$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => 'tv'));
			    				if($tag) {
			    					$unit->addTag($tag);
			    				}
			    			}
			    			if($data['Safe']) {
			    				$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => 'safe'));
			    				if($tag) {
			    					$unit->addTag($tag);
			    				}
			    			}
			    			if($data['A/C']) {
			    				$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => 'A/C'));
			    				if($tag) {
			    					$unit->addTag($tag);
			    				}
			    			}
			    			if($data['Internet']) {
			    				$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => 'internet'));
			    				if($tag) {
			    					$unit->addTag($tag);
			    				}
			    			}
			    			if($data['Tags']) {
			    				$tags = explode(',', $data['Tags']);
			    				$tags = array_map('trim', $tags);
			    				
			    				foreach($tags as $tagname) {
			    				$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => $tagname));
			    				if($tag) {
			    					$unit->addTag($tag);
			    				}
			    				}
			    			}
			    			
			    			if($unit->getPRef()) {
				    			$em->persist($unit);
			    			} else {
			    				$error_log .= 'Line '.$i.': Problem with P-Ref.<br/>';
			    				$error = true;
			    			}
				    		
				    		$user = $this->container->get('security.context')->getToken()->getUser();
				    							    		
				    		if (isset($data['K-Ref'])) {
				    			$contract = $em->getRepository('PHRentalsMainBundle:Contract')->findOneBy(array('kRef' => $data['K-Ref']));
				    		} else {
				    			$error_log .= 'Line '.$i.': K-Ref doesn\'t match existing contract '.$unit->getActiveContract()->getContract()->getKRef().'.<br/>';
				    			$error = true;
				    			$contract = null;
				    		}
				    		
				    		if($update && $contract && $unit->getActiveContract()) {
				    			if($contract->getId() != $unit->getActiveContract()->getContract()->getId()) {
				    				$error_log .= 'Line '.$i.': K-Ref doesn\'t match existing contract '.$unit->getActiveContract()->getContract()->getKRef().'.<br/>';
				    				$error = true;
				    			}
				    		} else {
				    			if(!$contract) {
				    				$notice_log .= 'Line '.$i.': New contract with K Ref #'.$data['K-Ref'].' created.<br/>';
				    			
				    				$contract = new Contract;
				    				if($data['K-Ref']) {
				    					$contract->setKRef($data['K-Ref']);
				    				} else {
				    					$contract->setPRef($this->container->get('doctrine')->getRepository('PHRentalsMainBundle:Contract')->findNextRef());
				    				}
				    				$contract->setOwner($owner);
				    				$contract->setCreatedByUser($user);
				    			} else {
				    				$notice_log .= 'Line '.$i.': Adding New Unit to existing contract with K Ref #'.$data['K-Ref'].'.<br/>';
				    			}
				    		}
				    		
				    		$contract->setUpdatedByUser($user);
			    				
			    			if(!$data['K.Status']) {
			    				$contract->setStatus($this->container->get('doctrine')->getRepository('PHRentalsMainBundle:ContractStatus')->find('7'));
			    			}
			    			else {
			    				if($data['K.Status']>0 && $data['K.Status']<10) {
			    						$contract->setStatus($this->container->get('doctrine')->getRepository('PHRentalsMainBundle:ContractStatus')->find($data['K.Status']));
			    				} else {
			    						$error_log .= 'Line '.$i.': Status id does not exist.<br/>';
			    						$error = true;
			    				}
			    			}
			    				
			    				
			    				
		    				if($data['Comm(%)']) {
		    					$fee = str_replace("%","",$data['Comm(%)']);
		    					$fee = str_replace(",",".",$fee);
		    					$contract->setAgencyFee($fee);
		    					$contract->setAgencyFeeWords($helper->noToWords($contract->getAgencyFee())." percent");
		    					if($fee == '5')  {
		    						$contract->setCommission('Regular');
		    					} else if($fee > '5')  {
		    						$contract->setCommission('Premium');
		    					}
		    				}
			    				
		    				if($data['Comm.note']) {
		    					$contract->setCommNote(br2nl($data['Comm.note']));
		    				}
			    				
		    				if(!$contract->getAgencyFeeWords() && $contract->getAgencyFee()) {
		    					$contract->setAgencyFeeWords($helper->noToWords($contract->getAgencyFee())." percent");
		    				}
			    				 
	    					$contract->setValidatedByUser($user);
	    					$date = new \DateTime('now');
	    					$contract->setValidatedOn($date);
	    					
	    					if($data['K.date']) {
	    						if (preg_match('/^([0-9]{2}\/[0-9]{2}\/[0-9]{4})/', $data['K.date'])) {
		    						$date_agreement = \DateTime::createFromFormat('d/m/Y', $data['K.date']);
		    						$contract->setAgreementDate($date_agreement);
	    						} else {
	    							$error_log .= 'Line '.$i.': Wrong Agreement Date format (DD/MM/YYYY).<br/>';
	    							$error = true;
	    						}
	    					}
	    					
	    					$contract->setAgencyDepositRate('10');
		    				
				    		if($data['K.Note'])
		    				$contract->setRemarks(br2nl($data['K.Note']));
		    				
		    				$purpose = $em->getRepository('PHRentalsMainBundle:ContractPurpose')->findOneBy(array('short' => $data['Purpose']));
		    				if($purpose) {
		    					$contract->setPurpose($purpose);
		    				}
		    				
		    				if($contract->getKRef()) {
		    					$em->persist($contract);
		    				} else {
		    					$error_log .= 'Line '.$i.': Problem with K-Ref.<br/>';
		    					$error = true;
		    				}
		    				
		    				// CONTRACT UNIT
		    				
		    				$contract_unit = $unit->getActiveContract();

		    				if(!$contract_unit) {
					    		$contract_unit = new ContractUnit();
				    			$contract_unit->setContract($contract);
				    			$contract_unit->setUnit($unit);
				    			$notice_log .= 'Line '.$i.': Unit added to contract K Ref #'.$data['K-Ref'].'.<br/>';
				    			 
		    				}
			    			
		    				if ($data['In.K'] == 'No') {
			    				$contract_unit->setIncontract(false);
		    				} else {
		    					$contract_unit->setIncontract(true);
		    				}

			    			if ($data['Sale.Price']) {
			    				$contract_unit->setSalePrice(preg_replace("/[^0-9]/","",$data['Sale.Price']));
			    				if($data['Negotiable'] == 'Yes') {
			    					$contract_unit->setNegotiable(true);
			    				}
			    			}

			    			if ($data['Rent-1y']) $contract_unit->setRental1Year(preg_replace("/[^0-9]/","",$data['Rent-1y']));
			    			if ($data['Rent-6m']) $contract_unit->setRental6Months(preg_replace("/[^0-9]/","",$data['Rent-6m']));
			    			if ($data['Rent-3m']) $contract_unit->setRental3Months(preg_replace("/[^0-9]/","",$data['Rent-3m']));
			    			if ($data['H.Rent.mo']) $contract_unit->setRentalMonthly(preg_replace("/[^0-9]/","",$data['H.Rent.mo']));
			    			if ($data['H.Rent.week']) $contract_unit->setRentalWeekly(preg_replace("/[^0-9]/","",$data['H.Rent.week']));
			    			if ($data['H.Rent.day']) $contract_unit->setRentalDaily(preg_replace("/[^0-9]/","",$data['H.Rent.day']));

							//utilities
			    			$utilities = array();
				    			if($data['Electric'])
				    				$utilities[] = "Utilities Electric ".$data['Electric']." Baht/unit";
				    			if($data['Water'])
				    				$utilities[] = "Utilities Water ".$data['Water']." Baht/unit";
				    			if($data['Cleaning'])
				    				$utilities[] = "Utilities Cleaning ".$data['Cleaning']." Baht/unit";
				    			if($data['WiFi'])
				    				$utilities[] = "Utilities Internet ".$data['WiFi']." Baht/unit";
			    			if($utilities) {
			    				$contract_unit->setUtilities(implode("\n",$utilities));
			    			}
			    			
			    			if($data['Keys.At']) $contract_unit->setKeysAtLevel($data['Keys.At']);
			    			 
			    			if(!$contract_unit->getSalePricePerSqm() && $contract_unit->getSalePrice() && $contract_unit->getUnit()->getLivingArea()) {
			    				$contract_unit->setSalePricePerSqm(round($contract_unit->getSalePrice()/$contract_unit->getUnit()->getLivingArea(),2));
			    			}
			    			
			    			if($data['Available']) {
			    				if (preg_match('/^([0-9]{2}\/[0-9]{2}\/[0-9]{4})/', $data['Available'])) {
			    					$date_available = \DateTime::createFromFormat('d/m/Y', $data['Available']);
			    					$contract_unit->setAvailableFrom($date_available);
			    				} else {
			    					$error_log .= 'Line '.$i.': Wrong Rental Available from Date format (DD/MM/YYYY).<br/>';
			    					$error = true;
			    				}
			    			}

			    			
			    			$em->persist($contract_unit);
			    			
			    			if(!$error) {
			    				$em->flush();
			    			}
		    			
		    			}

		    			
		    			
	    			}
    			}
    		}
    		
    		if(!$error) {
    			$defaultData = array('listing' => $headers);
    		}
    		

    		if ($error) {
    			$this->get('session')->setFlash('sonata_flash_error', 'NOT IMPORTED!');
    		} else {
    			$this->get('session')->setFlash('sonata_flash_success', 'All Units and Contracts imported.');
    		}
    		
    		
    	} 

	    	
	    	
	    	$next = array();
	    	$next['k'] = $this->container->get('doctrine')->getRepository('PHRentalsMainBundle:Contract')->findNextRef();
	    	$next['p'] = $this->container->get('doctrine')->getRepository('PHRentalsMainBundle:Unit')->findNextRef();
    	 
    	return $this->render('PHRentalsMainBundle:Admin:import.html.twig', array(
    			'action'   => 'listing',
    			'display' => $display,
    			'error' => $error_log,
    			'notice' => $notice_log,
    			'next' => $next,
    			'form' => $form->createView()
    	));
    
    }
    
    
    
}
?>

