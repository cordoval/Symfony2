<?php
namespace PHRentals\MainBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use PHRentals\MainBundle\Entity\Address as AddressEntity;
use PHRentals\MainBundle\Entity\Contract;
use PHRentals\MainBundle\Entity\ContractUnit;
use PHRentals\MainBundle\Entity\Unit;
use PHRentals\MainBundle\Controller\PDF;

class UnitAdminController extends Controller
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
    	
    	$units = null;
    	$stays = null;
    	$dates = null;
    	
    	$date_to = new \DateTime();
    	$date_to = $date_to->add(new \DateInterval('P3M'));
    	
    	$defaultData = array(
    			'from' => new \DateTime(),
    			'to' => $date_to
    	);
    	
    	// WITH CRITERIAS FROM FORM, SEARCH UNITS
    	$results = $this->get('request')->request->get('form');
    	
    	if ($this->get('request')->getMethod() == 'POST') {
    	//if ($results) {
    		
    		$defaultData = array(
    				'from' => new \DateTime($results['from']),
    				'to' => new \DateTime($results['to']),
    				'unitClass' => $results['unitClass'],
    				'unitSize' => $results['unitSize'],
    				'district' => $results['district'],
    				'size' => $results['size'],
    				'bedrooms' => $results['bedrooms'],
    				'bathrooms' => $results['bathrooms'],
    				'sleeps' => $results['sleeps'],
    				'distanceToBeach' => $results['distanceToBeach'],
    				'price' => $results['price'],
    		);
    		
	    	$units = $em->getRepository('PHRentalsMainBundle:Unit')->findAvailableUnits($results);
	    	
	    	//$nb_units = count($units);
	    	/*
	    	foreach($units as $unit) {
	    		print($unit->getName()."<br>");
	    	}
	    	*/
	
	    	
	    	// Calendar Code Start
	    	 
	    	$helper = $this->container->get('phrentals.helper.calendar');
	    	 
	    	$dates = $helper->createDatesForCalendar($results);
	    	
	    	// get stays of units
	    	
	    	$stays = $helper->createStays($units, $dates['from'], $dates['to']);
    	
    	
    	}
    	    	
    	    	
    	// CREATE FORM WITH CRITERIAS
    	    	
    	$unitClasses = array();
    	foreach($em->getRepository('PHRentalsMainBundle:UnitClass')->findAll() as $unitClass) {
    		$unitClasses[$unitClass->getId()] = $unitClass->getName();
    	}
    	
    	$unitSizes = array();
    	foreach($em->getRepository('PHRentalsMainBundle:UnitSize')->findAll() as $unitSize) {
    		$unitSizes[$unitSize->getId()] = $unitSize->getName();
    	}
    	 
    	$districts = array();
    	foreach($em->getRepository('PHRentalsMainBundle:District')->findAll() as $district) {
    		$districts[$district->getId()] = $district->getName();
    	}
    	
    	

    	
    	 
    	
    	$form = $this->createFormBuilder($defaultData, array('csrf_protection' => false))
    	->add('unitClass', 'choice', array('label' => 'Unit Type','choices' => $unitClasses ))
    	->add('unitSize', 'choice', array('label' => 'Unit Size','choices' => $unitSizes ))
    	->add('district', 'choice', array('label' => 'Dictrict','choices' => $districts ))
    	->add('bedrooms', 'choice', array('required' => false, 'label' => 'Number of Bedrooms', 'choices' => array('1' => '1','2' => '2','3' => '3','4' => '4')))
    	->add('bathrooms', 'choice', array('required' => false, 'label' => 'Number of Bathrooms', 'choices' => array('1' => '1','2' => '2','3' => '3','4' => '4')))
    	->add('sleeps', 'choice', array('required' => false, 'label' => 'Sleeps up to', 'choices' => array('1' => '1','2' => '2','3' => '3','4' => '4')))
    	->add('size', 'choice', array('required' => false, 'label' => 'Living Area (m²) >', 'choices' => array('20' => '20','25' => '25','30' => '30','35' => '35','40' => '40','45' => '45','50' => '50','55' => '55','60' => '60','65' => '65','70' => '70','75' => '75','80' => '80','85' => '85','90' => '90','95' => '95','100' => '100')))
    	->add('distanceToBeach', 'choice', array('required' => false, 'label' => 'Distance to Beach','choices' => AddressEntity::getDistanceToBeachList() ))
    	->add('price', 'text', array('required' => false, 'label' => 'Max daily price (฿)')) 
    	->add('from', 'date', array('label' => 'from','widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker', 'name' => 'from')))
    	->add('to', 'date', array('label' => 'to','widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker', 'name' => 'to')))
    	->getForm();
    	 
    	 
    	return $this->render('PHRentalsMainBundle:Admin:search.html.twig', array(
    			'action'   => 'search',
    			'object'   => $units,
    			'stays' => $stays,
    			'dates' => $dates,
    			'form' => $form->createView()
    	));
    	
    	
    }
    
    public function calendarAction() {
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$unit = $this->admin->getObject($id);
    	
    	if (!$unit) {
    		throw new NotFoundHttpException(sprintf('unable to find the unit with id : %s', $id));
    	}
    	
    	if (false === $this->admin->isGranted('VIEW', $unit)) {
    		throw new AccessDeniedException();
    	}
    	
    	$this->admin->setSubject($unit);
    	
    	// Calendar Code Start
    	
    	$helper = $this->container->get('phrentals.helper.calendar');
    	
    	$dates = $helper->createDatesForCalendar($this->get('request')->query->get('form'));
    	 
    	// Form to modify the dates
    	
    	$defaultData = array('from' => $dates['from'], 'to' => $dates['to']);
    	$form = $this->createFormBuilder($defaultData, array('csrf_protection' => false))
    	->add('from', 'date', array('attr' => array('name' => 'from'),'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker', 'name' => 'from')))
    	->add('to', 'date', array('attr' => array('name' => 'to'),'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker', 'name' => 'to')))
    	->getForm();
    	
    	$units = array();
    	$units[] = $unit;
    	 
    	$stays = $helper->createStays($units, $dates['from'], $dates['to']);
    	
    	// Calendar Code End
    	
    	return $this->render('PHRentalsMainBundle:Admin:calendar.html.twig', array(
    			'action'   => 'calendar',
    			'object'   => $unit,
    			'stays' => $stays,
    			'dates' => $dates,
    			'elements' => $this->admin->getShow(),
    			'form' => $form->createView()
    	));
    
    }
    
    public function createContractAction() {
    	 
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$unit = $this->admin->getObject($id);
    	 
    	if (!$unit) {
    		throw new NotFoundHttpException(sprintf('unable to find the unit with id : %s', $id));
    	}
    	 
    	if (false === $this->admin->isGranted('VIEW', $unit)) {
    		throw new AccessDeniedException();
    	}
    	 
    	$this->admin->setSubject($unit);
    	
    	$contract = new Contract;
    	$contract->setOwner($unit->getOwner());
    	$contract->setKRef($this->container->get('doctrine')->getRepository('PHRentalsMainBundle:Contract')->findNextRef());
    	$date = new \DateTime('now');
    	$contract->setAgreementDate($date);
    	$contract->setStatus($this->container->get('doctrine')->getRepository('PHRentalsMainBundle:ContractStatus')->find('3'));
    	$contract->setPurpose($this->container->get('doctrine')->getRepository('PHRentalsMainBundle:ContractPurpose')->findOneBy(array('name' => 'Sale only')));
    	 
    	$user = $this->container->get('security.context')->getToken()->getUser();
    	$contract->setCreatedByUser($user);
    	$contract->setCreatedOn($date);
    	$contract->setUpdatedByUser($user);
    	$contract->setUpdatedOn($date);
    	$contract->setValidatedByUser($user);
    	$contract->setValidatedOn($date);
    	
    	$contract_unit = new ContractUnit;
    	
    	$contract_unit->setContract($contract);
    	$contract_unit->setUnit($unit);
    	
    	$contract->addUnit($contract_unit);
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	$em->persist($contract);
    	
    	$em->flush();
    	 
    	$this->get('session')->setFlash('sonata_flash_success', sprintf('New Contract created from Unit!'));
    
    	return $this->redirect($this->generateUrl('admin_phrentals_main_contract_edit', array('id' => $contract->getId())));
    
    }
    
    public function catalogueAction() {
    	
    	global $header;
    	global $path ;
    	global $head_title;
    	global $head_address;
    	global $other_title;
    	global $other_address;
    	global $pdf_footer;
    	global $missing;
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	 
    	$unit = $this->admin->getObject($id);
    	
    	if (!$unit) {
    		throw new NotFoundHttpException(sprintf('unable to find the unit with id : %s', $id));
    	}
    	
    	if (false === $this->admin->isGranted('VIEW', $unit)) {
    		throw new AccessDeniedException();
    	}
    	
    	$this->admin->setSubject($unit);
    	
    	if ($unit->getProject()) {
    		$address = $unit->getProject()->getAddress();
    	} else {
    		$address = $unit->getAddress();
    	}
    	
    	// create PDF
    		
    	$path = 'http://'.$this->getRequest()->headers->get('host').$this->getRequest()->getBasePath();
    		
    	$em = $this->container->get('doctrine')->getEntityManager();
    		
    	$head_title = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Head Office Title');
    	$head_address = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Head Office Address');
    	$other_title = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Other Office Title');
    	$other_address = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Other Office Address');
    	$pdf_footer = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Footer');
    	$agency = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Agency');
    	
    	//$header = 'Unit Reference '.$unit->getPRef();
    	
    	$pdf = new PDF;
    	
    	$pdf->AddFont('Copperplate Gothic Bold','','COPRGTB.php');
    	$pdf->AddFont('Copperplate Gothic Light','','COPRGTL_0.php');
    		
    	$pdf->SetTitle($agency.' Catalogue - Unit #'.$unit->getPRef());
    	$pdf->SetAuthor($agency);
    	$pdf->AliasNbPages();
    	$pdf->AddPage();
    	
    	$pdf->SetFont('Times','',13);
    	
    	$ownership = "";
    	
    	if ($unit->getOwnership() == 'Thai/Company/Foreign') $ownership = 'T/C/F';
    	if ($unit->getOwnership() == 'Thai') $ownership = 'T';
    	if ($unit->getOwnership() == 'Company') $ownership = 'C';
    	if ($unit->getOwnership() == 'Foreign') $ownership = 'F';
    	if ($unit->getOwnership() == 'Company/Thai') $ownership = 'C/T';
    	
    	
    	$pdf->SetY(7);
    	$pdf->Cell(150);
    	$pdf->Cell(44,5,$unit->getClass(). ($ownership && $unit->getClass() == 'Condo' ? " (".$ownership.")" : "") .' / ' .$unit->getActiveContract()->getContract()->getPurpose(), 0, 0, 'R');
    	
    	
//T/C/F
    	
		$pdf->SetFont('Times','',10);
    	
		$num = 20;
		$plus = 6;
    	
		$pdf->SetY($num);
		$pdf->Cell(45);
    	
		$pdf->Cell(35,5,"Reference:", 0, 0, 'L');
    	
		$ref = array();
    	
		$ref[] = $unit->getPRef();
    	
    	if($unit->getOwner()->getOwnerRef()) {
		$ref[] = $unit->getOwner()->getOwnerRef();
    	}
    	if($unit->getActiveContract()) {
		$ref[] = $unit->getActiveContract()->getContract()->getKRef();
    	}
    	
    	$pdf->Cell(100,5,implode(" , ",$ref), 0, 0, 'L');
    	
    	$num = $num + $plus;
    	$pdf->SetY($num);
    	$pdf->Cell(45);
    	
    	if ($unit->getProject()) {
    		$pdf->Cell(35,5,"Project Name:", 0, 0, 'L');
    		$pdf->Cell(100,5,$unit->getProject(), 0, 0, 'L');
    	} else {
    		$pdf->Cell(35,5,"Address:", 0, 0, 'L');
    		$pdf->Cell(100,5,$address->getText(), 0, 0, 'L');
    	}
    	
		$num = $num + $plus;
		$pdf->SetY($num);
		$pdf->Cell(45);
		$pdf->Cell(35,5,"Location:", 0, 0, 'L');
		$location = $address->getDistrict(). ($unit->hasTag('sea view')? " (with seaview)" : "");
    	$pdf->Cell(100,5,$location, 0, 0, 'L');
    	$num = $num + $plus;
    	$pdf->SetY($num);
    	$pdf->Cell(45);
    	$pdf->Cell(35,5,"Size:", 0, 0, 'L');
    	$size = array();
    	if($unit->getLivingArea()) $size[] = $unit->getLivingArea()." sqm";
    	if($unit->getLandSize()) $size[] = $unit->getLandSize()." sqm";
    	$pdf->Cell(100,5,implode('/', $size), 0, 0, 'L');
    	$num = $num + $plus;
    	$pdf->SetY($num);
    	$pdf->Cell(45);
    	$pdf->Cell(35,5,"Beds:", 0, 0, 'L');
    	$bedrooms = ($unit->getUnitType() ? (($unit->getUnitType()->getName() == '# bedroom(s)')? $unit->getBedrooms().' bedroom'.($unit->getBedrooms()>1?'s':''):$unit->getUnitType()->getName()): "");
    	$pdf->Cell(100,5,$bedrooms, 0, 0, 'L');
    	$num = $num + $plus;
    	$pdf->SetY($num);
    	$pdf->Cell(45);
    	$pdf->Cell(35,5,"Facilities:", 0, 0, 'L');
    	$facilities =  array();
    	//if ($address->hasTag('shared swimming pool')) $facilities[] = "Shared Swimming Pool";
    	//if ($address->hasTag('private swimming pool')) $facilities[] = "Private Swimming Pool";
		/*if ($unit->hasTag('kitchen')) $facilities[] =  "Kitchen";
    	if ($unit->hasTag('cooking hob')) $facilities[] =  "Cooking Hob";
		if ($unit->hasTag('microwave')) $facilities[] =  "Microwave";
    	if ($unit->hasTag('fridge')) $facilities[] =  "Fridge";
		if ($unit->hasTag('TV')) $facilities[] =  "TV";
    	if ($unit->hasTag('safe')) $facilities[] =  "Safe";
		if ($unit->hasTag('internet')) $facilities[] =  "Internet";*/
    	//if ($address->hasTag('security')) $facilities[] =  "Security";
    	
    	foreach($address->getTags() as $tag) {
    		$facilities[] = ucwords($tag->getName());
    	}
    	foreach($unit->getTags() as $tag) {
    		$facilities[] = ucwords($tag->getName());
    	}
    	
    	
		$pdf->MultiCell(100,5,implode(', ', $facilities), 0);
    	
		if (strlen(implode(', ', $facilities)) > 55) {
			$num = $num + $plus;
		}
		if (strlen(implode(', ', $facilities)) > 110) {
			$num = $num + $plus;
		}
		if (strlen(implode(', ', $facilities)) > 165) {
			$num = $num + $plus;
		}
    	
		$num = $num + $plus;
		$pdf->SetY($num);
		$pdf->Cell(45);
		$pdf->Cell(35,5,"Distance to beach:", 0, 0, 'L');
		$pdf->Cell(100,5,$address->getDistanceToBeach(). " m", 0, 0, 'L');
    	
    	if ($unit->getActiveContract()->getRental1Year()>0 || $unit->getActiveContract()->getRentalMonthly()>0 || $unit->getActiveContract()->getRentalDaily()>0 || $unit->getActiveContract()->getRentalWeekly()>0) {
    	
    		$num = $num + $plus;
    		$pdf->SetY($num);
    		$pdf->Cell(45);
    		$pdf->Cell(35,5,"Rental Price:", 0, 0, 'L');
    		if ($unit->getActiveContract()->getRental1Year()>0) {
				$rental = "Yearly ".number_format($unit->getActiveContract()->getRental1Year())." THB / month";
    		$pdf->Cell(100,5,$rental, 0, 0, 'L');
    	}
    	if ($unit->getActiveContract()->getRentalMonthly()>0) {
				$rental = "Under 6 months ".number_format($unit->getActiveContract()->getRentalMonthly())." THB / month";
    	$num = $num + $plus;
    	$pdf->SetY($num);
    	$pdf->Cell(80);
    	$pdf->Cell(100,5,$rental, 0, 1, 'L');
    	}
    		
    	if ($unit->getActiveContract()->getRentalDaily()>0 || $unit->getActiveContract()->getRentalWeekly()>0) {
    		$rental_weekly = array();
    		if ($unit->getActiveContract()->getRentalDaily()>0) $rental_weekly[] = number_format($unit->getActiveContract()->getRentalDaily()*7);
    		if ($unit->getActiveContract()->getRentalWeekly()>0) $rental_weekly[] = number_format($unit->getActiveContract()->getRentalWeekly());
    	
    		$rental = "Holiday rental ".implode(" | ", $rental_weekly)." THB / week";
    		$num = $num + $plus;
    		$pdf->SetY($num);
    		$pdf->Cell(80);
    		$pdf->Cell(100,5,$rental, 0, 1, 'L');
    	}
    	}
    	if ($unit->getActiveContract()->getSalePrice()>0) {
		$num = $num + $plus;
		$pdf->SetY($num);
		$pdf->Cell(45);
		$pdf->Cell(35,5,"Sale Price:", 0, 0, 'L');
		$pdf->Cell(100,5,number_format($unit->getActiveContract()->getSalePrice())." THB", 0, 0, 'L');
		}
		$num = $num + $plus;
		$pdf->SetY($num);
		$pdf->Cell(45);
		$pdf->Cell(35,5,"Available:", 0, 0, 'L');
		
		$available = "";
		
		if ($unit->getActiveContract()) {
			if($unit->getActiveContract()->isAvailable()) {
				$available = 'Yes';
			} else {
				if($unit->getActiveContract()->getAvailableFrom()) {
					$available = 'From '.$unit->getActiveContract()->getAvailableFrom()->format('j, F Y');
				}
			}
		}
		
		$pdf->Cell(100,5,$available, 0, 0, 'L');
    	
		$num = 106;
    	
		$pdf->SetY($num);
		$pdf->SetX(55);
    	
		$four = 0;
		$i = 0;
		$baseurl = $this->getRequest()->getScheme() . '://' . $this->getRequest()->getHttpHost() . $this->getRequest()->getBasePath();
    	
		while ($four < 6 && $i <= 5) {
    				
    	$image = '../uploaded_file/property/'.$unit->getPRef().'/'.$i.'.jpg';
    	
    	//list($width, $height, $type, $attr) = getimagesize($image);
    	
    	//if ($type == "1" || $type == "2" || $type ==  "3") {
    		//print($type);
    	if (file_exists($image)) {
    		$pdf->Image($image,$pdf->GetX(), $pdf->GetY(), 72, 54.2);
    	}
    		//$four++	;
    	//}
    		
    	//print("<br>");
    	
    	if($i == 0 || $i == 2 || $i == 4)  {
    		$pdf->SetX(132);
    	} else {
    		$pdf->SetY($num+58);
    		$num = $num+58;
    		$pdf->SetX(55);
    	}
    	
    	$i++;
    	}
    	
    	
    	
    	
    	$path2 = $this->get('kernel')->getRootDir() . '/..';
    	
    	//if ($this->get('kernel')->getEnvironment() == 'dev') $path2 .= '/web';
    		
    	$pdf->Output($path2."/catalogue/".$unit->getPRef().".pdf","F");
    	
    	
    	$this->get('session')->setFlash('sonata_flash_success', sprintf('PDF Catalogue created for Unit!'));
    	
    	return $this->redirect($this->generateUrl('admin_phrentals_main_unit_display', array('id' => $unit->getId())));
    }
    
    public function displayAction($id = null)
    {
    	// the key used to lookup the template
    	$templateKey = 'display';
    
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    
    	$unit = $this->admin->getObject($id);
    
    	if (!$unit) {
    		throw new NotFoundHttpException(sprintf('unable to find the unit with id : %s', $id));
    	}
    
    	if (false === $this->admin->isGranted('EDIT', $unit)) {
    		throw new AccessDeniedException();
    	}
    
    	$this->admin->setSubject($unit);
    
    	$form = $this->admin->getForm();
    	$form->setData($unit);
    
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

    	return $this->render($this->admin->getTemplate('display'), array(
    			'action' => 'display',
    			'form'   => $view,
    			'unit' => $unit
    	));
    }
    
    public function detailsAction() {
    	 
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$unit = $this->admin->getObject($id);
    	 
    	if (!$unit) {
    		throw new NotFoundHttpException(sprintf('unable to find the unit with id : %s', $id));
    	}
    	 
    	if (false === $this->admin->isGranted('VIEW', $unit)) {
    		throw new AccessDeniedException();
    	}
    	 
    	$this->admin->setSubject($unit);
    	 
    	if ($unit->getProject()) {
    		$address = $unit->getProject()->getAddress();
    	} else {
    		$address = $unit->getAddress();
    	}
    	
    	return $this->render('PHRentalsMainBundle:Admin:unit-details.html.twig', array(
    			'unit' => $unit
    	));
    	 
    }
    
}
?>

