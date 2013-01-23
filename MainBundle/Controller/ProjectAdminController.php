<?php
namespace PHRentals\MainBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use PHRentals\MainBundle\Entity\Address as AddressEntity;
use PHRentals\MainBundle\Entity\Contract;
use PHRentals\MainBundle\Entity\ContractUnit;
use PHRentals\MainBundle\Entity\ContactEmail;
use PHRentals\MainBundle\Entity\ContactTel;

class ProjectAdminController extends Controller
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
    
    public function batchActionMerge() {
    
    	$em = $this->container->get('doctrine')->getEntityManager();
    
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    
    	$targetId = $this->get('request')->request->get('targetId');
    
    	print($targetId."<br>");
    
    	$idx = $this->get('request')->request->get('idx');
    
    	// remove targetID from idx
    	foreach($idx as $key => $value) {
    		if($targetId == $value)
    			unset($idx[$key]);
    	}
    
    
    	print_r($idx);
    
    	//exit;
    
    	$project = $this->admin->getObject($targetId);
    
    	if (!$project) {
    		throw new NotFoundHttpException(sprintf('Unable to find the project with id : %s', $id));
    	}
    
    	if (false === $this->admin->isGranted('EDIT', $project)) {
    		throw new AccessDeniedException();
    	}
    
    	$this->admin->setSubject($project);
    
    	// MERGE
    
    	$target = $em->getRepository('PHRentalsMainBundle:Project')->find($targetId);
    
    	$log = "Target : ". $target->getName().' - ';
    	$i = 0;
    
    	foreach($idx as $key => $value) {
    
    		$source = $em->getRepository('PHRentalsMainBundle:Project')->find($value);
    
    		$i++;
    
    		$log .= "Source ".$i." : ". $source->getName().' - ';
    		
    	if(!$target->getCompletedOn() && $source->getCompletedOn()) $target->setCompletedOn($source->getCompletedOn());
		if(!$target->getDescription() && $source->getDescription()) $target->setDescription($source->getDescription());
		if(!$target->getWebsite() && $source->getWebsite()) $target->setWebsite($source->getWebsite());
		if(!$target->getFurnished() && $source->getFurnished()) $target->setFurnished($source->getFurnished());
		if(!$target->getSinkingFund() && $source->getSinkingFund()) $target->setSinkingFund($source->getSinkingFund());
		if(!$target->getMaintenanceFee() && $source->getMaintenanceFee()) $target->setMaintenanceFee($source->getMaintenanceFee());
		if(!$target->getStartDate() && $source->getStartDate()) $target->setStartDate($source->getStartDate());
		if(!$target->getCompletion() && $source->getCompletion()) $target->setCompletion($source->getCompletion());
		if(!$target->getReservation() && $source->getReservation()) $target->setReservation($source->getReservation());
		if(!$target->getDeposit() && $source->getDeposit()) $target->setDeposit($source->getDeposit());
		if(!$target->getInstallments() && $source->getInstallments()) $target->setInstallments($source->getInstallments());
		if(!$target->getHandover() && $source->getHandover()) $target->setHandover($source->getHandover());
		if(!$target->getPriceSqmMin() && $source->getPriceSqmMin()) $target->setPriceSqmMin($source->getPriceSqmMin());
		if(!$target->getPriceSqmMax() && $source->getPriceSqmMax()) $target->setPriceSqmMax($source->getPriceSqmMax());
		if(!$target->getStudioMinSqm() && $source->getStudioMinSqm()) $target->setStudioMinSqm($source->getStudioMinSqm());
		if(!$target->getStudioMinPrice() && $source->getStudioMinPrice()) $target->setStudioMinPrice($source->getStudioMinPrice());
		if(!$target->getStudioMaxSqm() && $source->getStudioMaxSqm()) $target->setStudioMaxSqm($source->getStudioMaxSqm());
		if(!$target->getStudioMaxPrice() && $source->getStudioMaxPrice()) $target->setStudioMaxPrice($source->getStudioMaxPrice());
		if(!$target->getBed1minSqm() && $source->getBed1minSqm()) $target->setBed1minSqm($source->getBed1minSqm());
		if(!$target->getBed1minPrice() && $source->getBed1minPrice()) $target->setBed1minPrice($source->getBed1minPrice());
		if(!$target->getBed1maxSqm() && $source->getBed1maxSqm()) $target->setBed1maxSqm($source->getBed1maxSqm());
		if(!$target->getBed1maxPrice() && $source->getBed1maxPrice()) $target->setBed1maxPrice($source->getBed1maxPrice());
		if(!$target->getBed2minSqm() && $source->getBed2minSqm()) $target->setBed2minSqm($source->getBed2minSqm());
		if(!$target->getBed2minPrice() && $source->getBed2minPrice()) $target->setBed2minPrice($source->getBed2minPrice());
		if(!$target->getBed2maxSqm() && $source->getBed2maxSqm()) $target->setBed2maxSqm($source->getBed2maxSqm());
		if(!$target->getBed2maxPrice() && $source->getBed2maxPrice()) $target->setBed2maxPrice($source->getBed2maxPrice());
		if(!$target->getBed3minSqm() && $source->getBed3minSqm()) $target->setBed3minSqm($source->getBed3minSqm());
		if(!$target->getBed3minPrice() && $source->getBed3minPrice()) $target->setBed3minPrice($source->getBed3minPrice());
		if(!$target->getBed3maxSqm() && $source->getBed3maxSqm()) $target->setBed3maxSqm($source->getBed3maxSqm());
		if(!$target->getBed3maxPrice() && $source->getBed3maxPrice()) $target->setBed3maxPrice($source->getBed3maxPrice());
		if(!$target->getLaunched() && $source->getLaunched()) $target->setLaunched($source->getLaunched());
		if(!$target->getConstructionStarts() && $source->getConstructionStarts()) $target->setConstructionStarts($source->getConstructionStarts());
		if(!$target->getExpectedCompletion() && $source->getExpectedCompletion()) $target->setExpectedCompletion($source->getExpectedCompletion());
		if(!$target->getBuildDuration() && $source->getBuildDuration()) $target->setBuildDuration($source->getBuildDuration());
		if(!$target->getProjectType() && $source->getProjectType()) $target->setProjectType($source->getProjectType());
		if(!$target->getTotalBuildings() && $source->getTotalBuildings()) $target->setTotalBuildings($source->getTotalBuildings());
		if(!$target->getTotalUnits() && $source->getTotalUnits()) $target->setTotalUnits($source->getTotalUnits());
		if(!$target->getTotalFloors() && $source->getTotalFloors()) $target->setTotalFloors($source->getTotalFloors());
		if(!$target->getEiaStatus() && $source->getEiaStatus()) $target->setEiaStatus($source->getEiaStatus());
		if(!$target->getSales() && $source->getSales()) $target->setSales($source->getSales());
		if(!$target->getDirections() && $source->getDirections()) $target->setDirections($source->getDirections());
		if(!$target->getConfiguration() && $source->getConfiguration()) $target->setConfiguration($source->getConfiguration());
		if(!$target->getComposition() && $source->getComposition()) $target->setComposition($source->getComposition());
		if(!$target->getSalesPriceGuide() && $source->getSalesPriceGuide()) $target->setSalesPriceGuide($source->getSalesPriceGuide());
		if(!$target->getAmenities() && $source->getAmenities()) $target->setAmenities($source->getAmenities());
		if(!$target->getSecurity() && $source->getSecurity()) $target->setSecurity($source->getSecurity());
		if(!$target->getDescriptiontext() && $source->getDescriptiontext()) $target->setDescriptiontext($source->getDescriptiontext());
		if(!$target->getTelephone() && $source->getTelephone()) $target->setTelephone($source->getTelephone());
		
		// address
		if(!$target->getAddress()->getClass() && $source->getAddress()->getClass()) $target->getAddress()->setClass($source->getAddress()->getClass());
		if(!$target->getAddress()->getDistrict() && $source->getAddress()->getDistrict()) $target->getAddress()->setDistrict($source->getAddress()->getDistrict());
		if(!$target->getAddress()->getDistanceToBeach() && $source->getAddress()->getDistanceToBeach()) $target->getAddress()->setDistanceToBeach($source->getAddress()->getDistanceToBeach());
		if(!$target->getAddress()->getMap() && $source->getAddress()->getMap()) $target->getAddress()->setMap($source->getAddress()->getMap());
		if(!$target->getAddress()->getGpsLon() && $source->getAddress()->getGpsLon()) $target->getAddress()->setGpsLon($source->getAddress()->getGpsLon());
		if(!$target->getAddress()->getGpsLat() && $source->getAddress()->getGpsLat()) $target->getAddress()->setGpsLat($source->getAddress()->getGpsLat());
		
		// tags
		foreach($source->getAddress()->getTags() as $tag) { 
			$target->getAddress()->addTag($tag); 
		}
		
		if(!$target->getAddress()->getAdrStreet1() && !$target->getAddress()->getAdrStreet2() 
				&& !$target->getAddress()->getAdrStreet3() && !$target->getAddress()->getAdrStreet4() 
				&& !$target->getAddress()->getAdrStreet5() && !$target->getAddress()->getAdrStreet6()) { 
			$target->getAddress()->setAdrStreet1($source->getAddress()->getAdrStreet1());
			$target->getAddress()->setAdrStreet2($source->getAddress()->getAdrStreet2());
			$target->getAddress()->setAdrStreet3($source->getAddress()->getAdrStreet3());
			$target->getAddress()->setAdrStreet4($source->getAddress()->getAdrStreet4());
			$target->getAddress()->setAdrStreet5($source->getAddress()->getAdrStreet5());
			$target->getAddress()->setAdrStreet6($source->getAddress()->getAdrStreet6()); 
			$target->getAddress()->setAdrCity($source->getAddress()->getAdrCity());
			$target->getAddress()->setAdrProvince($source->getAddress()->getAdrProvince());
			$target->getAddress()->setAdrZip($source->getAddress()->getAdrZip());
			$target->getAddress()->setAdrCountry($source->getAddress()->getAdrCountry());
		}
			
    		
    // units
    		foreach($source->getUnits() as $property) {
    			 
    			print("ICI:".$property->getNum()."/".$property->getProject()->getId()."<br/>");
    			 
    			$property->setProject($target);
    			$source->removeUnit($property);
    			$target->addUnit($property);
    			 
    			print("ICI:".$property->getNum()."/".$property->getProject()->getId()."<br/>");
    
    		}
    
    		print($log);
    
    		
    		$em->persist($target);
    		$em->remove($source);
    		$em->flush();
    		
    	}
    
    	$em->persist($target);
    	$em->flush();
    	//exit;
    
    	// SEND BACK TO EDIT MODE OF DESTINATION CONTACT
    
    	$this->get('session')->setFlash('sonata_flash_success', sprintf('Merge results : %s', $log));
    
    	return $this->redirect($this->admin->generateUrl('edit', array('id' => $targetId)));
    
    
    }
    
    
}
?>

