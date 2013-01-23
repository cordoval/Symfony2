<?php
namespace PHRentals\MainBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use PHRentals\MainBundle\Entity\Address;
use PHRentals\MainBundle\Entity\Unit;
use PHRentals\MainBundle\Entity\UnitImage;
use PHRentals\MainBundle\Entity\Contract;
use PHRentals\MainBundle\Entity\ContractUnit;
use PHRentals\MainBundle\Entity\ContractUnitRanges;
use PHRentals\MainBundle\Entity\ContactEmail;
use PHRentals\MainBundle\Entity\ContactTel;
use PHPImageWorkshop\ImageWorkshop;
use \ZipArchive;

class OutsideAdminController extends Controller
{
    
    public function duplicateAction() {
        
    }
    
    public function listAction()
    {
    	if (false === $this->admin->isGranted('LIST')) {
    		throw new AccessDeniedException();
    	}
    
    	$datagrid = $this->admin->getDatagrid();
    	$pager = $datagrid->getPager();
    	$pager->setMaxPerPage(50);
    	$formView = $datagrid->getForm()->createView();
    	
    	// set the theme for the current Admin Form
    	$this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
    
    	return $this->render($this->admin->getTemplate('list'), array(
    			'action'   => 'list',
    			'form'     => $formView,
    			'datagrid' => $datagrid
    	));
    }
    
    public function editAction($id = null)
    {
    	// the key used to lookup the template
    	$templateKey = 'edit';
    
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    
    	$object = $this->admin->getObject($id);
    
    	if (!$object) {
    		throw new NotFoundHttpException(sprintf('unable to find the Property Online Listing Form object with id : %s', $id));
    	}
    
    	if (false === $this->admin->isGranted('EDIT', $object)) {
    		throw new AccessDeniedException();
    	}
    
    	$this->admin->setSubject($object);
    
    	$form = $this->admin->getForm();
    	$form->setData($object);
    
    	if ($this->get('request')->getMethod() == 'POST') {
    		$form->bindRequest($this->get('request'));
    
    		$isFormValid = $form->isValid();
    
    		// persist if the form was valid and if in preview mode the preview was approved
    		if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
    			$this->admin->update($object);
    			$this->get('session')->setFlash('sonata_flash_success', 'flash_edit_success');
    
    			if ($this->isXmlHttpRequest()) {
    				return $this->renderJson(array(
    						'result'    => 'ok',
    						'objectId'  => $this->admin->getNormalizedIdentifier($object)
    				));
    			}
    
    			// redirect to edit mode
    			return $this->redirectTo($object);
    		}
    
    		// show an error message if the form failed validation
    		if (!$isFormValid) {
    			$this->get('session')->setFlash('sonata_flash_error', 'flash_edit_error');
    		}
    	}
    
    	$view = $form->createView();
    
    	// set the theme for the current Admin Form
    	$this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());
    
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	
    	
    	$link = $this->get('router')->generate(
            'outside_edit',
            array('link' => $object->getLink()));
    	
    	if ($object->getUnit()) {
    		$email = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Property Online Listing Form - Update Email');
    	} else {
    		$email = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Property Online Listing Form - Create Email');
    	}
    	
    	if ($email) {
    		//$email = preg_replace('/<link>(.*)<many>/is', "", $email);
    		$email = str_replace("[link]", $link, $email, $count);
    		
    		$email = str_replace("[o-ref]", $object->getContact()->getOwnerRef(), $email, $count);
    		
    		$owner_emails = array();
    		foreach($object->getContact()->getEmails() as $contact_email) {
    			$owner_emails[] = $contact_email->getEmail();
    			}
    		$email = str_replace("[owner-email]", implode(",", $owner_emails), $email, $count);
    		
    		$owner_tels = array();
    		foreach($object->getContact()->getTels() as $tel) {
    			$owner_tels[] = $tel->getTel();
    		}
    		$email = str_replace("[owner-tel]", implode(",", $owner_tels), $email, $count);
    		
    		
    		if ($object->getUnit()) {
	    		$email = str_replace("[p-ref]", $object->getUnit()->getPRef(), $email, $count);
	    		$email = str_replace("[k-ref]", $object->getContract()->getKRef(), $email, $count);
	    		$email = str_replace("[unit]", $object->getUnit()->getNum(), $email, $count);
	    		if($object->getUnit()->getProject()) {
	    			$email = str_replace("[project]", $object->getUnit()->getProject()->getName(), $email, $count);
	    		} else {
	    			$email = str_replace("[project]", $object->getUnit()->getAddress(), $email, $count);
	    		}
    		} else {
	    		if($object->getClass()) {
	    			$email = str_replace("[unit]", $object->getClass()->getName(), $email, $count);
	    		}
	    		if($object->getProject()) {
	    			$email = str_replace("[project]", $object->getProject()->getName(), $email, $count);
	    		}
    		}

    		$email = str_replace("[owner-name]", $object->getContact()->getName(), $email, $count);
    	}
    	
    	// list files and create zip to download them all
    	
   	
    	$files = null;
    	$targetFolder = '../uploaded_file/listingform/'.$object->getId().'/';
    	
    	if(is_dir($targetFolder)) {
    		
    		if($object->getUnit()) {
	    		$zip = new \ZipArchive;
	    		$targetZip = '../uploaded_file/listingform/'.$object->getId().'/'.$object->getUnit()->getPRef().'.zip';
	    		$zip->open($targetZip, ZIPARCHIVE::CREATE);
    		}
    		
    		$files = scandir($targetFolder);
    		foreach ($files as $key => $file) {
    			if ($file === '.' || $file === '..' || substr(strrchr($file, '.'), 1) == 'zip') {
    				unset($files[$key]);
    			} else {
    				if(substr(strrchr($file, '.'), 1) != 'zip' && $object->getUnit()) {
    					$zip->addFile($targetFolder.$file, $file);
    				}
    			}
    		}
    		if($object->getUnit()) {
    			$files[] = $object->getUnit()->getPRef().'.zip';
    			$zip->close();
    		}
    	}
    	

    	return $this->render($this->admin->getTemplate('edit'), array(
    			'action' => 'edit',
    			'form'   => $view,
    			'email' => $email,
    			'object' => $object,
    			'files' => $files
    	));
    }
    
    public function integrateAction($id = null)
    {
    	$em = $this->container->get('doctrine')->getEntityManager();
    	 
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	 
    	$outside = $this->admin->getObject($id);
    	
    	if (!$outside) {
    		throw new NotFoundHttpException(sprintf('unable to find the Property Online Listing Form object with id : %s', $id));
    	}
    	
    	if (false === $this->admin->isGranted('EDIT', $outside)) {
    		throw new AccessDeniedException();
    	}
    	
    	$contact = $em->getRepository('PHRentalsMainBundle:Contact')->find($outside->getContact());
    	
    	$today = new \DateTime('now');
    	
    	// Case the owner wants to delete the listing
    	
    	if ($outside->getUnit() && $outside->getContract() && $outside->getToDelete()) {
    		
    		$unit = $em->getRepository('PHRentalsMainBundle:Unit')->find($outside->getUnit());
    		
    		$unit->setActive(false);
    		
    		$contract = $em->getRepository('PHRentalsMainBundle:Contract')->find($outside->getContract());
    		$contract_unit = $em->getRepository('PHRentalsMainBundle:ContractUnit')->find($outside->getContractUnit());
    		
    		$user = $this->container->get('security.context')->getToken()->getUser();
    		$contract->setUpdatedByUser($user);
    		$date = new \DateTime('now');
    		$contract->setUpdatedOn($date);

    		$contract_unit->setNotes('Unit removed from contract through the Property Online Listing Form on '.$date->format('d/m/Y').': '.$outside->getToDelete().'/'.$outside->getToDeleteText().'. '.$contract_unit->getNotes());
    		
    		$contract_unit->setIncontract(false);
    		
    		// if no other unit in contract, cancel contract
    		if(count($contract->getUnits()) == '1') {
	    		$contract->setDateExpiration($date);
	    		$contract->setRemarks('Contract modified through the Property Online Listing Form on '.$date->format('d/m/Y').', ('.$outside->getToDelete().'/'.$outside->getToDeleteText().'). '.$contract->getRemarks());
    		}
    		
    		$outside->setStatus('4/4 - listing cancelled');
    		
    		
    		$em->persist($unit);
    		
    		$em->persist($contract);
    		
    		$em->persist($contract_unit);

    		$em->persist($outside);
    		
    		$em->flush();
    	}
    	else {
    	
    	
	    // Case of an update of existing Unit
	    	if ($outside->getUnit()) {
	    	$unit = $em->getRepository('PHRentalsMainBundle:Unit')->find($outside->getUnit());
	    	}
	    	// Case of a new Unit
	    	else {
	    		$unit = new Unit;
	    		$unit->setPRef($em->getRepository('PHRentalsMainBundle:Unit')->findNextRef());
	    		$unit->setOwner($contact);
	    		$unit->setRemarks('Created from External Creation form on '.$today->format('d/m/Y'));
	    		$unit->setClass($outside->getClass());
	    	}
	    	
	    	if ($unit->getProject() || $unit->getAddress()) {
	    		if ($unit->getProject()) {
	    			$address = $unit->getProject()->getAddress();
		    	} else {
		    		$address = $unit->getAddress();
		    	}
	    	} else {
	    		if ($outside->getProject()) {
	    			$unit->setProject($em->getRepository('PHRentalsMainBundle:Project')->find($outside->getProject()));
	    			$address = $unit->getProject()->getAddress();
	    		} else {
	    			
	    			$address = new Address;
	    			$unit->setAddress($address);
	    		}
	    		
	    	}
	    	
	    	// Case of an update of existing Contract
	    	if($outside->getContract()) {
		    	$contract = $em->getRepository('PHRentalsMainBundle:Contract')->find($outside->getContract());
		    	$contract_unit = $em->getRepository('PHRentalsMainBundle:ContractUnit')->find($outside->getContractUnit());
	    	} else {
	    	// Case of an update of new Contract
	    		$contract = new Contract;
	    		$contract->setKRef($em->getRepository('PHRentalsMainBundle:Contract')->findNextRef());
	    		$contract->setOwner($contact);
	    		$contract->setStatus($em->getRepository('PHRentalsMainBundle:ContractStatus')->find('7'));
	    		$user = $this->container->get('security.context')->getToken()->getUser();
	    		$contract->setUpdatedByUser($user);
	    		$contract->setValidatedByUser($user);
	    		$date = new \DateTime('now');
	    		$contract->setValidatedOn($date);
	    		$contract->setCreatedByUser($user);
	    		$contract->setRemarks('Created from External Creation form on '.$today->format('d/m/Y'));
	    		$contract->setAgreementDate($today);
	    		
	    		$contract_unit = new ContractUnit();
	    		$contract_unit->setContract($contract);
	    		$contract_unit->setUnit($unit);
	    		
	    	}
	
	    	
	    	
	    	// update Entities
	    	
	    	//$contact->setName($outside->getName());
	    	if ($outside->getWeb()) $contact->setWeb($outside->getWeb());
	    	
	    	if($outside->getEmail()) {
		    	$email = new ContactEmail;
		    	$email->setEmail($outside->getEmail());
		    	$contact->addEmail($email);
	    	}
	    	if($outside->getEmail2()) {
		    	$email2 = new ContactEmail;
		    	$email2->setEmail($outside->getEmail2());
		    	$contact->addEmail($email2);
	    	}
	    	
	    	if($outside->getTel()) {
		    	$tel = new ContactTel;
		    	$tel->setTel($outside->getTel());
		    	$contact->addTel($tel);
	    	}
	    	
	    	if($outside->getTel2()) {
		    	$tel2 = new ContactTel;
		    	$tel2->setTel($outside->getTel2());
		    	$contact->addTel($tel2);
	    	}
	    	
	    	$contact->setPrefixName($outside->getPrefixName());
	    	$contact->setFirstName($outside->getFirstName());
	    	$contact->setLastName($outside->getLastName());
	    	
	    	if ($outside->getAge()) $contact->setAge($outside->getAge());
	    	$contact->setNationality($outside->getNationality());
	    	
	    	$contact->setAddressHome($outside->getAddressHome());
	    	if (!$outside->getSameAsUnitAddress() && $outside->getOwnerType() != 'Company') {
	    		$contact->setAddress($outside->getAddressUnit());
	    	} else {
	    		if ($outside->getAddress()) $contact->setAddress($outside->getAddress());
	    	}
	    	
	    	$contact->setValidation('complete');
	    	$contact->setNotes('Owner updated personal info on '.$today->format('d/m/Y'));
	    	$contact->setValidatedByUser($this->container->get('security.context')->getToken()->getUser());
	    	
	    	$unit->setNum($outside->getNum());
	    	//$unit->setClass($outside->getClass());
	    	//$unit->setProject($outside->getProject());
	    	$unit->setWebTitle($outside->getWebTitle());
	    	
	    	$unit->setOwnership($outside->getOwnership());
	
	    	$unit->setDescription($outside->getDescription());
	    	$unit->setLivingArea($outside->getLivingArea());
	    	
	    	if ($outside->getClass()->getId() == '2' || $outside->getClass()->getId() == '4') {
	    		$unit->setLandSize($outside->getLandSize());
	    	}
	    	
	    	$unit->setUnitType($outside->getUnitType());
	    	$unit->setFloor($outside->getFloor());
	    	$unit->setBedrooms($outside->getBedrooms());
	    	$unit->setBathrooms($outside->getBathrooms());
	    	$unit->setSleeps($outside->getSleeps());
	    	$unit->setHasExtraBed($outside->getHasExtraBed());
	    	$unit->setRemarks($outside->getRemarks());
	    	foreach($outside->getUnitTags() as $tag) {
	    		$unit->addTag($tag);
	    	}
	    	
	    	if (!$address->getText()) {
	    		$address->setText($outside->getAddressUnit());
	    	}
	    	if (!$address->getDistrict()) {
	    		$address->setDistrict($outside->getDistrict());
	    	}
	    	if (!$address->getDistanceToBeach()) {
	    		$address->setDistanceToBeach($outside->getDistanceToBeach());
	    	}
	
	    	foreach($outside->getAddressTags() as $tag) {
	    		$address->addTag($tag);
	    	}
	    	
	    	$contract->setValidatedOn(new \DateTime('now'));
	    	$contract->setValidatedByUser($this->container->get('security.context')->getToken()->getUser());
	    	 
	    	$contract_unit->setIncontract(true);
	    	 
	    	if ($outside->getIncontract() == false) {
	    		if ($outside->getAvailableFrom()) {
		    		//$from = date_create_from_format('d/m/Y', $outside->getAvailableFrom());
		    		$contract_unit->setAvailableFrom($outside->getAvailableFrom());
	    		}
	    		
	    		if ($outside->getRentedDateFrom()) {
	    			$range = new ContractUnitRanges();
	    			$range->setContractUnit($contract_unit);
	    			$range->setDateFrom($outside->getRentedDateFrom());
	    			$range->setDateTo($outside->getRentedDateTo());
	    			$range->setNote($outside->getRentedNote());
	    		}
	    	}
	    	
	    	if(($outside->getPurposeSale() && $outside->getPurposeRent()) || ($outside->getPurposeSale() && $outside->getPurposeRentHoliday())) {
	    		$contract->setPurpose($em->getRepository('PHRentalsMainBundle:ContractPurpose')->findOneBy(array('name' => 'Sale and Rent')));
	    	} elseif (!$outside->getPurposeSale() && ($outside->getPurposeRent() || $outside->getPurposeRentHoliday())) {
	    		$contract->setPurpose($em->getRepository('PHRentalsMainBundle:ContractPurpose')->findOneBy(array('name' => 'Rent Only')));
	    	} else {
	    		$contract->setPurpose($em->getRepository('PHRentalsMainBundle:ContractPurpose')->findOneBy(array('name' => 'Sale Only')));
	    	}
	    	
	    	if($outside->getPurposeSale()) {
	    		$contract_unit->setSalePrice($outside->getSalePrice());
	    		$contract_unit->setNegotiable($outside->getNegotiable());
	    		$contract_unit->setTransferFeeBy($outside->getTransferFeeBy());
		
		    	$contract->setAgencyFee($outside->getAgencyFee());
		    	$contract->setAgencyDepositRate($outside->getAgencyDepositRate());
		    	$contract->setCommNote($outside->getCommNote());
		    	
		    	if ($outside->getAgencyFee() == '5') {
		    		$contract->setCommission('Regular');
		    	}
	    	} else {
	    		$contract_unit->setSalePrice(null);
	    	}
	    	
	    	if($outside->getPurposeRent()) {
	    		$contract_unit->setRental3Months($outside->getRental3Months());
	    		$contract_unit->setRental6Months($outside->getRental6Months());
	    		$contract_unit->setRental1Year($outside->getRental1Year());
	    	} else {
	    		$contract_unit->setRental3Months(null);
	    		$contract_unit->setRental6Months(null);
	    		$contract_unit->setRental1Year(null);
	    	}
	    	
	    	if($outside->getPurposeRentHoliday()) {
	    		$contract_unit->setRentalDaily($outside->getRentalDaily());
	    		$contract_unit->setRentalWeekly($outside->getRentalWeekly());
	    		$contract_unit->setRentalMonthly($outside->getRentalMonthly());
	    	} else {
	    		$contract_unit->setRentalDaily(null);
	    		$contract_unit->setRentalWeekly(null);
	    		$contract_unit->setRentalMonthly(null);
	    	}	
	    	
	    	$contract_unit->setInspection($outside->getInspection());
	    	$contract_unit->setKeysAtLevel($outside->getKeysAtLevel());
	    	$contract_unit->setDeposit($outside->getDeposit());
	    	$contract_unit->setConditions($outside->getConditions());
	    	$contract_unit->setUtilities($outside->getUtilities());
	    	$contract_unit->setCheckinTimes($outside->getCheckinTimes());
	    	$contract_unit->setCheckoutTimes($outside->getCheckoutTimes());
	    	$contract_unit->setIsOwnerCaretaker($outside->getIsOwnerCaretaker());
	    	$contract_unit->setCaretaker($outside->getCaretaker());
	    	
	    	if (!$outside->getCaretaker()) {
	    	$contract_unit->setCaretakerPhone($outside->getCaretakerPhone());
	    	$contract_unit->setCaretakerEmail($outside->getCaretakerEmail());
	    	$contract_unit->setCaretakerEmail($outside->getCaretakerEmail());
	    	}
	    	
	    	// start - amounts to words
	    	$helper = $this->container->get('phrentals.helper.prices');
	    	
	    	if($outside->getPurposeSale() && $outside->getAgencyFee()) {
	    		$contract->setAgencyFeeWords($helper->noToWords($outside->getAgencyFee())." percent");
	    	}
	    	if($outside->getPurposeSale() && $outside->getSalePrice()) {
	    		$contract_unit->setSalePriceWords($helper->noToWords($contract_unit->getSalePrice())." Baht");
	    	}
	    	
	    	if($outside->getPurposeRentHoliday() && $outside->getRentalMonthly()) {
	    		$contract_unit->setRentalMonthlyWords($helper->noToWords($contract_unit->getRentalMonthly())." Baht");
	    	}
	    	if($outside->getPurposeRent() && $outside->getRental1Year()) {
	    		$contract_unit->setRentalMonthlyWords($helper->noToWords($contract_unit->getRental1Year())." Baht");
	    	}
	    	
	    	if($outside->getPurposeSale() && $outside->getSalePrice() && $outside->getLivingArea()) {
	    		$contract_unit->setSalePricePerSqm(round($outside->getSalePrice()/$outside->getLivingArea(),2));
	    	}
	    	
	    	// end - amounts to words
	    	
	    	// unit rating
	    	$rating = 0;
	    	 
	    	if(!$unit->getRating()) {
	    	
	    		if ($contract_unit->getSalePricePerSqm()) {
	    			$rating = ($contract_unit->getSalePricePerSqm()/60000)*$address->getDistrict()->getFactor();
	    		}
	    		elseif ($unit->getLivingArea()>0) {
	    			$rating = ($contract_unit->getSalePrice()/$unit->getLivingArea()/60000)*$address->getDistrict()->getFactor();
	    		}
	    	
	    		if ($unit->getFeatured()) {
	    			$rating = $rating * 120/100;
	    		}
	    	
	    		if(($rating = round($rating,2)) > 0) {
	    			$unit->setRating($rating);
	    		}
	    	
	    	}
	    	// slug
	    	$unit->setSlug($em->getRepository('PHRentalsMainBundle:Unit')->createSlug($unit));
	    	
	    	$outside->setStatus('4/4 - listing imported');
	    	$outside->setValidatedOn(new \DateTime('now'));
	    	$outside->setValidatedByUser($this->container->get('security.context')->getToken()->getUser());
	    	
	    	if(!$outside->getUnit()) {
	    		$outside->setUnit($unit);
	    	}
	    	if(!$outside->getContract()) {
	    		$outside->setContract($contract);
	    	}
	    	
	    	// files
	    	 
	    	$files = null;
	    	$targetFolder = '../uploaded_file/listingform/'.$outside->getId().'/';
	    	if(is_dir($targetFolder)) {
	    		$files = scandir($targetFolder);
	    		foreach ($files as $key => $file) {
	    			if ($file === '.' || $file === '..') unset($files[$key]);
	    		}
	    	}
	    	
	    	if ($files) {
	    	foreach ($files as $key => $file) {
	    		
	    		$resized = ImageWorkshop::initFromPath($targetFolder.'/'.$file);
	    		$thumbnail = clone $resized;
	    		
	    		$resized->resizeInPixel('465', '350');
	    		$thumbnail->resizeInPixel('154', '115');
	    		
	    		$filename = 0;
	    			
	    		if(count($unit->getImages())>0) {
	    			foreach($unit->getImages() as $image) {
	    				$image_split = explode(".",$image->getName());
	    				if(is_numeric($image_split[0]) && $image_split[0] >= $filename) {
	    					$filename = intval($image_split[0]);
	    					$filename++;
	    				}
	    			}
	    		}
	    		if($filename == "") {
	    			$filename = 0;
	    		}
	    		$filename = $filename.".jpg";
	    		
	    		$resized->save(__DIR__.'/../../../../../'.'uploaded_file/property/'.$unit->getPRef(), $filename, true, null, '70');
	    		$thumbnail->save(__DIR__.'/../../../../../'.'uploaded_file/property/thumb/'.$unit->getPRef(), $filename, true, null, '70');
	    		 
	    		chmod(__DIR__.'/../../../../../'.'uploaded_file/property/'.$unit->getPRef(), 0777);
	    		chmod(__DIR__.'/../../../../../'.'uploaded_file/property/thumb/'.$unit->getPRef(), 0777);
	    		chmod(__DIR__.'/../../../../../'.'uploaded_file/property/'.$unit->getPRef().'/'.$filename, 0777);
	    		chmod(__DIR__.'/../../../../../'.'uploaded_file/property/thumb/'.$unit->getPRef().'/'.$filename, 0777);
	    		
	    		$unit_image = new UnitImage;
	    		$unit_image->setName($filename);
	    		$unit_image->setPath('uploaded_file/property/'.$unit->getPRef().'/'.$filename);
	    		$unit_image->setUnit($unit);
	    		$em->persist($unit_image);
	    		$unit->addImage($unit_image);	
	    	}
	    	}
	    	
	    	// PERSISTING ENTITIES
	    	
	    	$em->persist($contact);
	    	
	    	
	    	$em->persist($unit);
	    	
	    	$em->persist($address);
	    	$em->persist($contract);
	
	    	$em->persist($contract_unit);
	    	if(isset($range)) {
	    		$em->persist($range);
	    	}
	    	$em->persist($outside);
	    	
	    	$em->flush();
    	
    	}
    	// end
    	
    	$this->admin->setSubject($outside);
    	
    	$this->get('session')->setFlash('sonata_flash_success', 'Property Online Listing Form data imported.');
    	
    	return $this->redirect($this->generateUrl('admin_phrentals_main_outside_edit', array('id' => $id)));
    	 
    	
    }
    
    public function imagedeleteAction($id = null, $file = null) {
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$outside = $this->admin->getObject($id);
    	 
    	if (!$outside) {
    		throw new NotFoundHttpException(sprintf('unable to find the Property Online Listing Form object with id : %s', $id));
    	}
    	 
    	if (false === $this->admin->isGranted('EDIT', $outside)) {
    		throw new AccessDeniedException();
    	}
    	
    	
    	unlink(__DIR__.'/../../../../../uploaded_file/listingform/'.$outside->getId().'/'.$file);
    	
    	$files = scandir(__DIR__.'/../../../../../uploaded_file/listingform/'.$outside->getId());
    	
    	if (count($files) < 3)
    	{
    		rmdir(__DIR__.'/../../../../../uploaded_file/listingform/'.$outside->getId());
    	}
    	
    	$this->get('session')->setFlash('sonata_flash_success', 'Image '.$file.' deleted.');
    	
    	return $this->redirect($this->generateUrl('admin_phrentals_main_outside_edit', array('id' => $id)));
    
    }
    
    public function imagedeleteallAction($id = null) {
    	 
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	 
    	$outside = $this->admin->getObject($id);
    
    	if (!$outside) {
    		throw new NotFoundHttpException(sprintf('unable to find the Property Online Listing Form object with id : %s', $id));
    	}
    
    	if (false === $this->admin->isGranted('EDIT', $outside)) {
    		throw new AccessDeniedException();
    	}
    	 
    	$files = scandir(__DIR__.'/../../../../../uploaded_file/listingform/'.$outside->getId());
    	
    	foreach($files as $file) {
    		if ($file != '.' && $file != '..') {
    			unlink(__DIR__.'/../../../../../uploaded_file/listingform/'.$outside->getId().'/'.$file);
    		}
    	}
    	 
    	rmdir(__DIR__.'/../../../../../uploaded_file/listingform/'.$outside->getId());
    	 
    	$this->get('session')->setFlash('sonata_flash_success', 'All Images and folder deleted.');
    	 
    	return $this->redirect($this->generateUrl('admin_phrentals_main_outside_edit', array('id' => $id)));
    
    }
    
}
?>

