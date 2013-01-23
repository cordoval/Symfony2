<?php
namespace PHRentals\MainBundle\Controller;

use PHRentals\MainBundle\Entity\ContactType;

use PHRentals\MainBundle\Entity\Outside;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class ContactAdminController extends Controller
{
	
	public function listAction()
	{
		if (false === $this->admin->isGranted('LIST')) {
			throw new AccessDeniedException();
		}
	
		$datagrid = $this->admin->getDatagrid();
		$pager = $datagrid->getPager();
		$pager->setMaxPerPage(2000);
		$formView = $datagrid->getForm()->createView();
	
		// set the theme for the current Admin Form
		$this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
	
		return $this->render($this->admin->getTemplate('list'), array(
				'action'   => 'list',
				'form'     => $formView,
				'datagrid' => $datagrid
		));
	}
    
    public function searchAction() {
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	$contacts = null;
    	
    	$defaultData = array(
    	);
    	
    	// WITH CRITERIAS FROM FORM, SEARCH UNITS
    	$results = $this->get('request')->request->get('form');
    	
    	$search = 0;
    	
    	if ($this->get('request')->getMethod() == 'POST') {
    	//if ($results) {
    		
    		$defaultData = array(
    				'generalsearch' => trim($results['generalsearch']),
    				//'contactType' => $results['contactType'],
    				'pRef' => trim($results['pRef']),
    				'oRef' => trim($results['oRef']),
    				'kRef' => trim($results['kRef'])
    				
    		);
    		
    		$results = array_map('trim', $results);
    		
	    	$contacts = $em->getRepository('PHRentalsMainBundle:Contact')->findContacts($results);
	    	
	    	$search = 1;
    	}
    	    	
    	    	
    	// CREATE FORM WITH CRITERIAS
    	    	
    	$contactTypes = array();
    	foreach($em->getRepository('PHRentalsMainBundle:ContactType')->findAll() as $contactType) {
    		$contactTypes[$contactType->getId()] = $contactType->getName();
    	}
    	
    	$form = $this->createFormBuilder($defaultData, array('csrf_protection' => false))
    	->add('generalsearch', 'text', array('required' => false, 'label' => 'General Search'))
    	//->add('contactType', 'choice', array('label' => 'Contact Type','choices' => $contactTypes, 'expanded'=>true,'multiple'=>true ))
    	->add('pRef', 'text', array('required' => false, 'label' => 'Property Ref (P)'))
    	->add('oRef', 'text', array('required' => false, 'label' => 'Owner Ref (O)'))
    	->add('kRef', 'text', array('required' => false, 'label' => 'Contract Ref (K)'))
    	->getForm();
    	
    	// NEXT K-REF and P-REF values
    	
    	$next = array();
    	$next['k'] = $this->container->get('doctrine')->getRepository('PHRentalsMainBundle:Contract')->findNextRef();
    	$next['p'] = $this->container->get('doctrine')->getRepository('PHRentalsMainBundle:Unit')->findNextRef();
    	 
    	return $this->render('PHRentalsMainBundle:Admin:contact-search.html.twig', array(
    			'action'   => 'search',
    			'object'   => $contacts,
    			'search' => $search,
    			'next' => $next,
    			'form' => $form->createView()
    	));
    	
    	
    }
    
    public function batchActionMerge() {
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$targetId = $this->get('request')->request->get('targetId');
    	
    	//print($targetId."<br>");
    	
    	$idx = $this->get('request')->request->get('idx');
    	
    	// remove targetID from idx
    	foreach($idx as $key => $value) {	
    		if($targetId == $value)
    		unset($idx[$key]);
    	}
    	
    	
    	//print_r($idx);
    	
    	//exit;
    	
    	$contact = $this->admin->getObject($targetId);
    	
    	if (!$contact) {
    		throw new NotFoundHttpException(sprintf('unable to find the contact with id : %s', $id));
    	}
    	
    	if (false === $this->admin->isGranted('EDIT', $contact)) {
    		throw new AccessDeniedException();
    	}
    	
    	$this->admin->setSubject($contact);
    	
    	// MERGE
    	
    	$target = $em->getRepository('PHRentalsMainBundle:Contact')->find($targetId);
    	
    	$log = "Target : ". $target->getName().' - ';
    	$i = 0;
    	
    	foreach($idx as $key => $value) {
    		
    		$source = $em->getRepository('PHRentalsMainBundle:Contact')->find($value);
    		
    		$i++;
    		
    		$log .= "Source ".$i." : ". $source->getName().' - ';
    		
    		// old ref
    		if($target->getOldOwnerRef() == '' && $source->getOldOwnerRef() != '') {
    			$target->setOldOwnerRef($source->getOldOwnerRef());
    			$log .= 'Added old ref from '.$source->getOwnerRef().' - ';
    		}
    		
    		if($target->getOldOwnerRef() != '' && $source->getOldOwnerRef() != '') {
    			$log .= 'Not added old ref from '.$source->getOwnerRef().' = '.$source->getOldOwnerRef().' - ';
    		}
    		
    		// address
    		if($target->getAddress() == '' && $source->getAddress() != '') {
    			$target->setAddress($source->getAddress());
    			$log .= 'Added address from '.$source->getOwnerRef().' - ';
    		}
    		
    		if($target->getAddress() != '' && $source->getAddress() != '') {
    			$log .= 'Not added address from '.$source->getOwnerRef().' = '.$source->getAddress().' - ';
    		}
    		
    		// contact Types
    		foreach($source->getContactTypes() as $contact_type) {
    			
    			$target->removeContactType($contact_type);
    			$target->addContactType($contact_type);
    			$log .= 'Added contact type from '.$source->getOwnerRef().' = '.$contact_type->getName().' - ';
    		}
    		
    		// email
    		foreach($source->getEmails() as $email) {
    			
    			$found= false;
    			foreach($target->getEmails() as $email2) {
    				if ($email->getEmail() == $email2->getEmail()) {
    					$found = true;
    				}
    			}
    			
    			if (!$found) {
    			$source->removeEmail($email);
    			$target->addEmail($email);
    			$em->persist($email);
    			$log .= 'Added email from '.$source->getOwnerRef().' = '.$email->getEmail().' - ';
    			}
    		}

    		// tel
    		foreach($source->getTels() as $tel) {
    			 
    			$found= false;
    			foreach($target->getTels() as $tel2) {
    				if ($tel->getTel() == $tel2->getTel()) {
    					$found = true;
    				}
    			}
    			 
    			if (!$found) {
    				$source->removeTel($tel);
    				$target->addTel($tel);
    				$em->persist($tel);
    				$log .= 'Added tel from '.$source->getOwnerRef().' = '.$tel->getTel().' - ';
    			}
    		}
    		
    		// Representative
    		foreach($source->getReps() as $representative) {
    			 
    			$found= false;
    			foreach($target->getReps() as $representative2) {
    				if ($representative->getName() == $representative2->getName()) {
    					$found = $representative2;
    				}
    			}
    			 
    			if (!$found) {
    				$log .= 'before ' . $representative->getContact()->getName(). ' - ';
    				$source->removeRep($representative);
    				$target->addRep($representative);
    				$log .= 'after ' . $representative->getContact()->getName(). ' - ';
    				$em->persist($representative);
    				$log .= 'Added Representative from '.$source->getOwnerRef().' = '.$representative->getName().' - ';
    			}
    			else {
    				if($representative->getEmail() != '' && $found->getEmail() == '') {
    					$found->setEmail($representative->getEmail());
    					$log .= 'Added email to '.$found->getName().' from '.$source->getOwnerRef().' - ';
    				}	
    				if($representative->getTel() != '' && $found->getTel() == '') {
    					$found->setTel($representative->getTel());
    					$log .= 'Added Tel to '.$found->getName().' from '.$source->getOwnerRef().' - ';
    				}
    				if($representative->getNote() != '' && $found->getNote() == '') {
    					$found->setNote($representative->getNote());
    					$log .= 'Added Note to '.$found->getName().' from '.$source->getOwnerRef().' - ';
    				}
    			}
    		}
    		
    	    		// Propertie
    		foreach($source->getUnits() as $property) {
    				$source->removeUnit($property);
    				$target->addUnit($property);
    				$property->setOwner($target);
    				//$em->persist($property);
    				$log .= 'Added Property = '.$property->getPRef().' - ';
    				//print("<br>2a) ".$property->getContact()->getId());
    		}
    		
    		$em->persist($target);
    		$em->remove($source);
    		$em->flush();
    	}
    	
    	//$em->persist($target);
    	//$em->flush();

    	// SEND BACK TO EDIT MODE OF DESTINATION CONTACT
    	$this->get('session')->setFlash('sonata_flash_success', sprintf('Merge results : %s', $log));
    	 
    	return $this->redirect($this->admin->generateUrl('edit', array('id' => $targetId)));
    	
    
    }
    
    public function createUpdateLinkAction() {
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	//$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$unit_id = $this->get('request')->get('unit_id');
    	
    	$unit = $em->getRepository('PHRentalsMainBundle:Unit')->find($unit_id);
    	 
    	if (!$unit) {
    		$this->get('session')->setFlash('sonata_flash_error', sprintf('Unable to find the unit with id : %s.', $unit_id));
    		return $this->redirect($this->admin->generateUrl('edit', array('id' => $id)));
    	}
    	
    	$contact = $this->admin->getObject($unit->getOwner()->getId());
    	 
    	if (!$contact) {
    		throw new NotFoundHttpException('unable to find the contact');
    	}
    	 
    	if (false === $this->admin->isGranted('EDIT', $contact)) {
    		throw new AccessDeniedException();
    	}
    	 
    	$this->admin->setSubject($contact);
    	
    	if ($unit->getProject()) {
    		$address = $unit->getProject()->getAddress();
    	} else {
    		$address = $unit->getAddress();
    	}
    	
    	$contract_unit = $em->getRepository('PHRentalsMainBundle:ContractUnit')->findOneBy(array('unit' => $unit));
    	
    	$contract = $contract_unit->getContract();
    	
    	
    	// CREATE AN "OUTSIDE OBJECT" TO MAKE A COPY OF UPDATABLE FIELDS
    	
    	$outside = new Outside();
    	
    	$outside->setCreatedOn(new \DateTime('now'));
		$outside->setCreatedByUser($this->container->get('security.context')->getToken()->getUser());
		//$outside->setUpdatedOn();
		
		// create unique link slug
		//$slug = $contact->getName().$unit->getpRef();
		//$slug = base64_encode($slug);
		//$slug = str_replace(array('+','/','='),array('-','_','%'),$slug);
		
		$notfound = true;
		
		while ($notfound) {
		$slug = md5(uniqid(rand(), true));
		$slug = substr($slug, 0, 9);
		
		$outside_exists = $em->getRepository('PHRentalsMainBundle:Outside')->findOneBy(array('link' => $slug));
		if (!$outside_exists) {
			$notfound = false;		
		}
		}

		$outside->setLink($slug);
		$outside->setStatus('1/4 - listing link created');
		
		
		// contact info
		
		if($contact->hasType('Developer') || $contact->hasType('Agency')) {
			$outside->setOwnerType('Company');
		}
		else {
			$outside->setOwnerType('Private Owner');
		}
		
		$outside->setContact($contact);
		$outside->setName($contact->getName());
		$outside->setWeb($contact->getWeb());
		if($email = $contact->getEmail()->first()) {
			$outside->setEmail($email->getEmail());
		}
		if($tel = $contact->getTels()->first()) {
			$outside->setTel($tel->getTel());
		}
		if($tel = $contact->getTels()->next()) {
			$outside->setTel2($tel->getTel());
		}
		$outside->setPrefixName($contact->getPrefixName());
		$outside->setFirstName($contact->getFirstName());
		$outside->setLastName($contact->getLastName());
		$outside->setAge($contact->getAge());
		$outside->setNationality($contact->getNationality());
		$outside->setAddressHome($contact->getAddressHome());
		$outside->setAddress($contact->getAddress());
		
		// unit info
		$outside->setUnit($unit);
		$outside->setNum($unit->getNum());
		$outside->setClass($unit->getClass());
		$outside->setProject($unit->getProject());
		$outside->setWebTitle($unit->getWebTitle());
		$outside->setOwnership($unit->getOwnership());
		$outside->setDescription($unit->getDescription());
		$outside->setLivingArea($unit->getLivingArea());
		$outside->setLandSize($unit->getLandSize());
		$outside->setUnitType($unit->getUnitType());
		$outside->setFloor($unit->getFloor());
		$outside->setBedrooms($unit->getBedrooms());
		$outside->setBathrooms($unit->getBathrooms());
		$outside->setSleeps($unit->getSleeps());
		$outside->setHasExtraBed($unit->getHasExtraBed());
		$outside->setRemarks($unit->getRemarks());
		foreach($unit->getTags() as $tag) {
			$outside->addUnitTag($tag);
		}
		
		// address
		$outside->setAddressUnit($address->getText());
		$outside->setDistrict($address->getDistrict());
		$outside->setDistanceToBeach($address->getDistanceToBeach());
		foreach($address->getTags() as $tag) {
			$outside->addAddressTag($tag);
		}
		
		// contract
		$outside->setContract($contract);
		if ($contract->getPurpose()->getId() == '1' || $contract->getPurpose()->getId() == '3') {
			$outside->setPurposeSale(true);
		}
		if ($contract->getPurpose()->getId() == '2' || $contract->getPurpose()->getId() == '3') {
			$outside->setPurposeRent(true);
		}
		$outside->setAgencyFee($contract->getAgencyFee());
		$outside->setAgencyDepositRate($contract->getAgencyDepositRate());
		$outside->setCommNote($contract->getCommNote());
		
		// contract_unit
		$outside->setContractUnit($contract_unit);
		$outside->setIncontract($contract_unit->getIncontract());
		
		if($contract_unit->getInspection()) {
			$outside->setInspection($contract_unit->getInspection());
		} else {
			$outside->setInspection("Key located at/with:\nName of person who can show unit:\nMobile phone for inspections:\nInspection Notes:");
		}
		$outside->setKeysAtLevel($contract_unit->getKeysAtLevel());
		$outside->setAvailableFrom($contract_unit->getAvailableFrom());
		$outside->setSalePrice($contract_unit->getSalePrice());
		$outside->setNegotiable($contract_unit->getNegotiable());
		if ($contract_unit->getTransferFeeBy()) {
			$outside->setTransferFeeBy($contract_unit->getTransferFeeBy());
		} else {
			$outside->setTransferFeeBy('50/50 Owner and Buyer');
		}
		$outside->setDeposit($contract_unit->getDeposit());
		
		$outside->setRentalDaily($contract_unit->getRentalDaily());
		$outside->setRentalWeekly($contract_unit->getRentalWeekly());
		$outside->setRentalMonthly($contract_unit->getRentalMonthly());
		$outside->setRental3Months($contract_unit->getRental3Months());
		$outside->setRental6Months($contract_unit->getRental6Months());
		$outside->setRental1Year($contract_unit->getRental1Year());
		
		if($contract_unit->getConditions()) {
			$outside->setConditions($contract_unit->getConditions());
		} else {
			$outside->setConditions("Advance/Booking fee for 'Holiday Rental' ___% the of total price.\nHoliday rentals are accepted ___ months in advance");
		}
		if ($contract_unit->getUtilities()) {
			$outside->setUtilities($contract_unit->getUtilities());
		} else {
			$outside->setUtilities("Electric: _______ Baht / unit\nWater: _______ Baht / unit\nWi-Fi: _______ Baht / (month) / (week) / (day)\nOther charges: _____________");
		}
		$outside->setCheckinTimes($contract_unit->getCheckinTimes());
		$outside->setCheckoutTimes($contract_unit->getCheckoutTimes());
		$outside->setIsOwnerCaretaker($contract_unit->getIsOwnerCaretaker());
		$outside->setCaretaker($contract_unit->getCaretaker());
		$outside->setCaretakerPhone($contract_unit->getCaretakerPhone());
		$outside->setCaretakerEmail($contract_unit->getCaretakerEmail());
		$outside->setCaretakerEmail($contract_unit->getCaretakerEmail());
		
		$em->persist($outside);
		$em->flush();
    	
    	//print_r(new Outside());
    	//exit;
    	
    	
    	
    	
    	// SEND BACK TO EDIT MODE OF DESTINATION CONTACT
    	$this->get('session')->setFlash('sonata_flash_success', 'Property Online Listing Form created.');
 
    	return $this->redirect($this->generateUrl('admin_phrentals_main_outside_edit', array('id' => $outside->getId())));
    	
    }
    
    public function createNewUpdateLinkAction() {
    	 
    	$em = $this->container->get('doctrine')->getEntityManager();
    	 
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	 
    	$contact = $this->admin->getObject($id);
    
    	if (!$contact) {
    		throw new NotFoundHttpException(sprintf('unable to find the contact with id : %s', $id));
    	}
    
    	if (false === $this->admin->isGranted('EDIT', $contact)) {
    		throw new AccessDeniedException();
    	}
    
    	$this->admin->setSubject($contact);
    	
    	$results = $this->get('request')->request->get('form');
    	 
    	if ($this->get('request')->getMethod() == 'POST') {
    		
    		//print_r($results['projects']);
    		$project_id = json_decode($results['projects'])->value;
    		
	    	// CREATE AN "OUTSIDE OBJECT" TO CREATE A NEW UNIT
	    	 
	    	$outside = new Outside();
	    	 
	    	$outside->setCreatedOn(new \DateTime('now'));
	    	$outside->setCreatedByUser($this->container->get('security.context')->getToken()->getUser());
	    	//$outside->setUpdatedOn();
	    
	    	// create unique link slug
	    	//$slug = $contact->getName().$unit->getpRef();
	    	//$slug = base64_encode($slug);
	    	//$slug = str_replace(array('+','/','='),array('-','_','%'),$slug);
	    
	    	$notfound = true;
	    
	    	while ($notfound) {
	    		$slug = md5(uniqid(rand(), true));
	    		$slug = substr($slug, 0, 9);
	    
	    		$outside_exists = $em->getRepository('PHRentalsMainBundle:Outside')->findOneBy(array('link' => $slug));
	    		if (!$outside_exists) {
	    			$notfound = false;
	    		}
	    	}
	    
	    	$outside->setLink($slug);
	    	$outside->setStatus('1/4 - listing link created');
	    
	    
	    	// contact info
	    
	    	if($contact->hasType('Developer') || $contact->hasType('Agency')) {
	    		$outside->setOwnerType('Company');
	    	}
	    	else {
	    		$outside->setOwnerType('Private Owner');
	    	}
	    
	    	$outside->setContact($contact);
	    	$outside->setName($contact->getName());
	    	$outside->setWeb($contact->getWeb());
	    	if($email = $contact->getEmail()->first()) {
	    		$outside->setEmail($email->getEmail());
	    	}
	    	if($tel = $contact->getTels()->first()) {
	    		$outside->setTel($tel->getTel());
	    	}
	    	if($tel = $contact->getTels()->next()) {
	    		$outside->setTel2($tel->getTel());
	    	}
	    	$outside->setPrefixName($contact->getPrefixName());
	    	$outside->setFirstName($contact->getFirstName());
	    	$outside->setLastName($contact->getLastName());
	    	$outside->setAge($contact->getAge());
	    	$outside->setNationality($contact->getNationality());
	    	$outside->setAddressHome($contact->getAddressHome());
	    	$outside->setAddress($contact->getAddress());
	    	
	    	$outside->setAgencyFee('5');
	    	$outside->setAgencyDepositRate('10');
	    	$outside->setDeposit('2 months rent');
	    	$outside->setIsOwnerCaretaker(true);
	    	
	    	$outside->setInspection("Key located at/with:\nName of person who can show unit:\nMobile phone for inspections:\nInspection Notes:");
	    	$outside->setTransferFeeBy('50/50 Owner and Buyer');
	    	$outside->setConditions("Advance/Booking fee for 'Holiday Rental' ___% the of total price.\nHoliday rentals are accepted ___ months in advance");
	    	$outside->setUtilities("Electric: _______ Baht / unit\nWater: _______ Baht / unit\nWi-Fi: _______ Baht / (month) / (week) / (day)\nOther charges: _____________");
	    	
	    	
	    	$outside->setClass($em->getRepository('PHRentalsMainBundle:UnitClass')->find($results['unitClass']));
	    	
	    	if(!isset($results['standalone'])) {
		    	$project = $em->getRepository('PHRentalsMainBundle:Project')->find($project_id);
			    $address = $project->getAddress();
		    	
		    	$outside->setProject($project);
		    
		    	// address
		    	$outside->setAddressUnit($address->getText());
		    	$outside->setDistrict($address->getDistrict());
		    	$outside->setDistanceToBeach($address->getDistanceToBeach());
		    	foreach($address->getTags() as $tag) {
		    		$outside->addAddressTag($tag);
		    	}
	    	}
	    
	    	$em->persist($outside);
	    	$em->flush();
	    	 
	    	//print_r(new Outside());
	    	//exit;
    	 
	    	// SEND BACK TO EDIT MODE OF DESTINATION CONTACT
	    	$this->get('session')->setFlash('sonata_flash_success', 'External Create Form created.');
	    
	    	return $this->redirect($this->generateUrl('admin_phrentals_main_outside_edit', array('id' => $outside->getId())));
	    	//return $this->redirect($this->generateUrl('admin_phrentals_main_contact_edit', array('id' => $contact->getId())));
	    } 
	    else 
	    {
	    	
	        $unitClasses = array();
	    	foreach($em->getRepository('PHRentalsMainBundle:UnitClass')->findAll() as $unitClass) {
	    		$unitClasses[$unitClass->getId()] = $unitClass->getName();
	    	}
	    	
	    	$projects = array();
	    	foreach($em->getRepository('PHRentalsMainBundle:Project')->findBy(array(), array('name' => 'asc')) as $project) {
	    		$projects[$project->getId()] = $project->getName();
	    	}
	    	
	    	$form = $this->createFormBuilder(array('unitClass' => '1', 'standalone' => false), array('csrf_protection' => false))
	    	->add('unitClass', 'choice', array('label' => 'Unit Class','choices' => $unitClasses, 'required'  => true))
    		//->add('projects', 'choice', array('label' => 'Project','choices' => $projects, 'required'  => true))
    		->add('projects', 'genemu_jqueryautocompleter_entity', array(
    				'label' => 'Project',
    				'required' => false,
    				'route_name' => 'ajax_project',
    				'class' => 'PHRentals\MainBundle\Entity\Project'
    		))
    		->add('standalone', 'checkbox', array('label' => 'Standalone unit?', 'required'  => false))
	    	->getForm();
	    	
	    	return $this->render('PHRentalsMainBundle:Admin:contact-externalcreation.html.twig', array(
	    			'object'   => $contact,
	    			'form' => $form->createView()
	    	));
	    }
    	 
    }
    
    
}
?>

