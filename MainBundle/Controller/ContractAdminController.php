<?php
namespace PHRentals\MainBundle\Controller;

use PHRentals\MainBundle\Entity\Contract;
use PHRentals\MainBundle\Entity\ContractUnit;
use PHRentals\MainBundle\Entity\Unit;
use PHRentals\MainBundle\Entity\Address;
use PHRentals\MainBundle\Entity\Contact;
use PHRentals\MainBundle\Entity\Project;

use PHRentals\MainBundle\Controller\PDF;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Locale\Locale;

class ContractAdminController extends Controller
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
	

	private function createPdf($contract, $contract_ref, $text, $title, $signing, $purpose = null) {
		
		global $header;
		global $path ;
		global $head_title;
		global $head_address;
		global $other_title;
		global $other_address;
		global $pdf_footer;
		global $missing;
		
		$helper = $this->container->get('phrentals.helper.prices');
		 
		//$path = $this->get('kernel')->getRootDir() . '/../web';
		$path = 'http://'.$this->getRequest()->headers->get('host').$this->getRequest()->getBasePath();
		 
		$em = $this->container->get('doctrine')->getEntityManager();
		 
		$head_title = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Head Office Title');
		$head_address = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Head Office Address');
		$other_title = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Other Office Title');
		$other_address = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Other Office Address');
		$pdf_footer = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Footer');
		$agency = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Agency');
		
		$date_format = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Date Format');
 
 
$fields = array(
'[kref]' => array('contract', 'KRef'),
'[oref]' => array('owner', 'OwnerRef'),
'[pref]' => array('unit', 'PRef'),
'[project-name]' => array('project', 'Name'),
'[agency-office]' => array('contract', 'Agency'),
'[agreement-date]' => array('contract', 'AgreementDate'),
'[owner-name]' => array('owner', 'Name'),
'[owner-age]' => array('owner', 'Age'),
'[owner-nationality]' => array('owner', 'Nationality'),
'[owner-address]' => array('owner', 'FullAddress'),
'[owner-tel]' => array('owner', 'Tel'),
'[owner-email]' => array('owner', 'Email'),
'[agent-full-name]' => array('contract_unit', 'Agent'),
'[lease-agreement-date]' => array('contract_unit', 'LeaseAgreementDate'),
//'[property-address]' => array('address', 'FullAddress'),
'[tenant-prefix]' => array('tenant', 'PrefixName'),
'[tenant-first-name]' => array('tenant', 'FirstName'),
'[tenant-last-name]' => array('tenant', 'LastName'),
'[tenant-age]' => array('tenant', 'Age'),
'[tenant-nationality]' => array('tenant', 'Nationality'),
'[tenant-address]' => array('tenant', 'Address'),
'[tenant-tel]' => array('tenant', 'Tel'),
'[tenant-email]' => array('tenant', 'Email'),
'[date-start-lease]' => array('contract_unit', 'LeaseStartOn'),
'[lease-months]' => array('contract_unit', 'LeaseNbMonths'),
'[agency-fee]' => array('contract', 'AgencyFee'),
'[agency-fee-words]' => array('contract', 'AgencyFeeWords'),
'[deposit]' => array('contract', 'AgencyDepositRate'),
'[monthly-payment-words]' => array('contract_unit', 'RentalMonthlyWords'),
'[monthly-payment]' => array('contract_unit', 'RentalMonthly'),
'[property-size]' => array('unit', 'LivingArea'),
'[damage-deposit]' => array('contract_unit', 'deposit'),
'[date-move-in]' => array('contract_unit', 'MoveinOn'),
'[repair-cost]' => array('contract_unit', 'MaxRepairCostPerMonth')
		);

		$unit_list_per_project = array();
		$unit_list = "";
		
		$unit_table = array();

		foreach($contract->getUnits() as $contract_unit) {
		
			$unit = $contract_unit->getUnit();
			$owner = $contract->getOwner();
			
			//$property = $unit->getNum();
			
			if($unit->getProject()) {
				$address = $unit->getProject()->getAddress();
				//$project = $unit->getProject();
				$index = $unit->getProject().", located at ".$unit->getProject()->getAddress()->getDistrict();
				$full_address = $unit->getProject()->getAddress()->getFullAddress();
			} else {
				$address = $unit->getAddress();
				$index = $unit->getClass()->getName().", located at ".$address->getDistrict();
				$full_address = $unit->getAddress()->getFullAddress();
			}
			
			$property =  $unit->getClass()->getName();
			
			if($unit->getNum()) {
			$property .= " ".$unit->getNum();
			}

			$unit_table_type = "";
			if ($unit->getUnitType()) {
				$unit_table_type = ($unit->getUnitType()->getName() == '# bedroom(s)'? $unit->getBedrooms()." bedroom".($unit->getBedrooms()>1?"s":""):$unit->getUnitType());
			}
			if ($unit->getLivingArea()>0) {
				if($unit_table_type != "") $unit_table_type .= ", ";
				$unit_table_type .= $unit->getLivingArea()." sqm";
			}
			if ($unit->getLandSize()>0) {
				if($unit_table_type != "") $unit_table_type .= ", ";
				$unit_table_type .= $unit->getLandSize()." sqm";
			}
			$property .= " (P-ref: ".$unit->getPRef().", ".$unit_table_type;
			
			if($unit->getFloor()) {
				if($unit->getClass()->getName() == 'Condo') {
				$property .= ", ".$unit->getFloor().$helper->ordinalSuffix($unit->getFloor())." floor";
				}
				if($unit->getClass()->getName() == 'House') {
					$property .= ", ".$unit->getFloor()." storey".($unit->getFloor()>1?"1":"");
				}
			}
			$property .= "),";
			
			if($purpose == 'R') {
						
			$rent_list = array();
				if($contract_unit->getRental1Year()>0) {
					$rent_list[] = "a 1 Year rent of ".number_format($contract_unit->getRental1Year())." Baht/month (".$helper->noToWords($contract_unit->getRental1Year())." Baht/month)";
				}
				if ($contract_unit->getRental6Months()>0) {
					$rent_list[] = "a 6 months rent of ".number_format($contract_unit->getRental6Months())." Baht/month (".$helper->noToWords($contract_unit->getRental6Months())." Baht/month)";
				}
				if ($contract_unit->getRental3Months()>0) {
					$rent_list[] = "a 3 months rent of ".number_format($contract_unit->getRental3Months())." Baht/month (".$helper->noToWords($contract_unit->getRental3Months())." Baht/month)";
				}
				if ($contract_unit->getRentalMonthly()>0) {
					$rent_list[] = "a holiday rental monthly rent of ".number_format($contract_unit->getRentalMonthly())." Baht/month (".$helper->noToWords($contract_unit->getRentalMonthly())." Baht/month)";
				}
				if ($contract_unit->getRentalDaily()>0) {
					$rent_list[] = "a holiday rental daily rent of ".number_format($contract_unit->getRentalDaily())." Baht/month (".$helper->noToWords($contract_unit->getRentalDaily())." Baht/month)";
				}
				$property .= " with ".implode(", ", $rent_list);
			}
			$unit_list_per_project[$index]['units'][] = $property;
			$unit_list_per_project[$index]['address'] = $full_address;
			
			/*
			$unit_table_line = array();
			$unit_table_line[] = $unit->getPRef();
			$unit_table_line[] = $unit->getClass()->getName()." ".$unit->getNum();
			$unit_table_line[] = ($unit->getProject()? $unit->getProject()->getName():$unit->getAddress()->getText());
			$unit_table_line[] = $unit->getFloor().ordinalSuffix($unit->getFloor())." floor";
			$unit_table_type = "";
			if ($unit->getUnitType()) {
				$unit_table_type = ($unit->getUnitType()->getName() == '# bedroom(s)'? $unit->getBedrooms()." bedroom".($unit->getBedrooms()>1?"s":""):$unit->getUnitType());
			}
			if ($unit->getLivingArea()) {
				$unit_table_type .= $unit->getLivingArea()." m²";
			}
			$unit_table_line[] = $unit_table_type;
			$unit_table_line[] = $contract_unit->getSalePrice();
			 
			 $unit_table[] = $unit_table_line;
			 */
		}
		
		$unit_table_list = "";
		
		$i = 1;
		
		foreach($unit_list_per_project as $key => $properties) {
			
			if($unit_list != "") {
				$unit_list .= ", ";
			}
			if (count($contract->getUnits()) != 1) {
				//$unit_list .= "- ";
			$unit_list .= $key;
			} else {
				$unit_list .= $key.". Unit as following: ".implode("", $properties['units']);
			}
			
			$unit_table_list .= $i.") ".$key."
Address: ".$properties['address']."
Units as following :\n- ".implode($properties['units'], "\n- ")."\n\n";
			
			$i++;

		}
		
		if (count($contract->getUnits()) > 1) {
			$unit_list .= " (list of properties in appendix)";
		}
		
		
		//Grande Caribbean Condo Resort, located at Thappraya,
		//Nongprue, Banglamuang, Pattaya, Chonburi, 20150, Thailand. unit/s as following: 505 (Ref#5005a001), 506 (Ref#5005a002)
		
		
		
		
		// only 1 unit
		if (count($contract->getUnits()) == 1) {
			$text = preg_replace('/<many>(.*)<many>/is', "", $text);
			$text = str_replace("<one>", "", $text, $count);
		} else {
			$text = preg_replace('/<one>(.*)<one>/is', "", $text);
			$text = str_replace("<many>", "", $text, $count);
		}
		
		$text = str_replace("[unit-list]", $unit_list, $text, $count);
		
		$unit_table_text = "";
		foreach($unit_table as $unit_line) {
			$unit_table_text.= implode(", ", $unit_line)."
					";
					
		}
		
		//$text = str_replace("[unit-table]", $unit_table_text, $text, $count);
		
		
		
		if (!$owner->getAge()) {
			$text = preg_replace('/<age>(.*)<age>/is', "", $text);
		} else {
			$text = str_replace("<age>", "", $text, $count);
		}
		if (!$owner->getNationality()) {
			$text = preg_replace('/<nationality>(.*)<nationality>/is', "", $text);
		} else {
			$text = str_replace("<nationality>", "", $text, $count);
		}
	
		$tenant = new Contact;
		
		$missing = array();
		
		
		foreach($fields as $key => $value) {
	
			
			$entity = $value[0];
			$method = "get".$value[1];
			
			//print($entity." ".$method);
			//exit;
			
			$what = "";
			
			switch ($key) {
				case '[owner-name]':
					if($owner->getPrefixName() && $owner->getFirstName() && $owner->getLastName()) {
						$what = $owner->getPrefixName()." ".$owner->getFirstName()." ".$owner->getLastName();
					} else {
						$what = $owner->getName();
					}
					break;
				case '[agreement-date]':
				case '[lease-agreement-date]':
				case '[date-start-lease]':
				case '[due-date-of-payment]':
					$what = $$entity->$method();
					if ($what) {
						$what = $what->format($date_format);
					}
					
					break;
				case '[agency-fee-words]':
							$helper = $this->container->get('phrentals.helper.prices');
							$what = $helper->noToWords($contract->getAgencyFee())." percent";
						break;
				case '[monthly-payment-words]':
					$what = $$entity->$method();
					if($what == '') {
						$helper = $this->container->get('phrentals.helper.prices');
						if($contract_unit->getRental1Year()>0) {
							$what = $contract_unit->getRental1Year();
						} elseif ($contract_unit->getRental6Months()>0) {
							$what = $contract_unit->getRental6Months();
						} elseif ($contract_unit->getRental3Months()>0) {
							$what = $contract_unit->getRental3Months();
						} elseif ($contract_unit->getRentalMonthly()>0) {
							$what = $contract_unit->getRentalMonthly();
						}
						$what = $helper->noToWords($what)." Baht";
					}
					break;
				case '[monthly-payment]':
					$what = null;
					if($contract_unit->getRental1Year()>0) {
						$what = $contract_unit->getRental1Year();
					} elseif ($contract_unit->getRental6Months()>0) {
						$what = $contract_unit->getRental6Months();
					} elseif ($contract_unit->getRental3Months()>0) {
						$what = $contract_unit->getRental3Months();
					} elseif ($contract_unit->getRentalMonthly()>0) {
						$what = $contract_unit->getRentalMonthly();
					}
					$what = number_format($what);
					break;
				case '[owner-address]':
					$what = $$entity->$method();
					if (!$what) {
						$what = $address->getText();
					}
					break;
				case '[agency-office]':
					$what = $agency;
					break;
				case '[owner-tel]':
					foreach($owner->getTels() as $tel) {
						$what = $tel->getTel();
					}
					if (!$what) {
						$text = preg_replace('/<tel>(.*)<tel>/is', "", $text);
					} else {
						$text = str_replace("<tel>", "", $text, $count);
					}
					break;
				case '[owner-email]':
					foreach($owner->getEmails() as $email) {
						$what = $email->getEmail();
					}
					if (!$what) {
						$text = preg_replace('/<email>(.*)<email>/is', "", $text);
					} else {
						$text = str_replace("<email>", "", $text, $count);
					}
					break;
				case '[project-name]':
					if($unit->getProject()) {
						$what = $unit->getProject()->getName();
					} else {
						$what = "";
					}
					break;
				default:
					$what = $$entity->$method();
			}
			
			
			/*
			if(substr($value, 0, 5) == "owner" && $owner && $key != 'b2') {

					$method = "get".str_replace("owner", "", $value);
					$what = $owner->$method();
 
			}  
			elseif(substr($value, 0, 7) == "tenant.") {
				$what = $contract->getTenant();
				if($what) {
				$method = "get".str_replace("tenant.", "", $value);
				$what = $what->$method();
				}
				
			} else {
	
				$method = "get".$value;
				if (method_exists($contract,$method)) {
					$what = $contract->$method();
				}
	
				if (is_a($what, 'DateTime')) {
					$what = $what->format('j F, Y');
				}
	
			}
			*/
	/*
			switch ($key) {
				case 'd5':
					$what = $what*100;
					$what = $what." %";
					break;
				case 'd6':
					$what = $what*100;
					$what = $what." %";
					break;
				case 'a2':
					$what = $agency;
					break;
				case 'a10':
				case 'c5':
					
					$countries = Locale::getDisplayCountries(Locale::getDefault());
					if($what) {
					$what = $countries[$what];
					}
					
					break;
			}
			*/
	
			//print($what."<br>");
	
			if ($what == "" || $what == null) $what = "_________________";
			$count = 0;
			$text = str_replace($key, $what, $text, $count);
			
			if ($count>0) {
				$missing[] = $fields[$key];
			}
	
			 
		}
		 
		//print($text);
		//exit;
		 
		// Create PDF
	
		// HEADER
		if ($owner) { $owner_ref = $contract->getOwner()->getOwnerRef(); }
		else  { $owner_ref = "New Owner"; }
		
		$header = 'Contract Reference '.$contract_ref;
	
		$pdf = new PDF;
		
		$pdf->AddFont('Copperplate Gothic Bold','','COPRGTB.php');
		$pdf->AddFont('Copperplate Gothic Light','','COPRGTL_0.php');
		 
		$pdf->SetTitle($agency." - Contract ".$contract_ref);
		$pdf->SetAuthor($agency);
		$pdf->AliasNbPages();
		$pdf->AddPage();
	
	
		// Title
		$pdf->SetFont('Times','',16);
	
		$pdf->Cell(23);
		$pdf->MultiCell(0,5,$title);
		/*
		$pdf->SetFont('Times','',12);
		$pdf->SetY(34);
		$pdf->Cell(70);
		$title = "Contract ".$contract_ref;
		$pdf->MultiCell(0,5,$title);
		$pdf->SetY(40);
		$pdf->Cell(70);
		$title = "Property Ref#".$unit->getPRef();
		$pdf->MultiCell(0,5,$title);
	*/
	
		// Text
		$pdf->SetFont('Times','',11);
	
		$pdf->SetY(40);
		$pdf->Cell(50);
		//$pdf->MultiCell(0,5,$text);
		
		$i = 1;
		$pages = explode("<page-break>", $text);
		$len = count($pages);
		
		foreach ($pages as $page) {
			if ($i != 1) {
				$pdf->SetY(20);
				$pdf->Cell(50);
			}
			$pdf->MultiCell(0,5,$page);
			if ($i != $len) {
				$pdf->AddPage();
			}
			$i++;
		}
		
	
		$pdf->Ln(40);
	
		$sign_line = "______________________                            ______________________";
	
		$pdf->Cell(50);
		$pdf->Cell(0,5,$sign_line);
		$pdf->Ln(5);
		$pdf->Cell(50);
		$pdf->Cell(0,5,$signing."                                                        The Agent");
		$pdf->Ln(5);
		$pdf->Cell(50);
		
		if($contract->getOwner()->getFirstName() && $contract->getOwner()->getLastName()) {
			$what = $contract->getOwner()->getFirstName()." ".$contract->getOwner()->getLastName();
		} else {
			$what = $contract->getOwner()->getName();
		}
		
		
		$pdf->Cell(22,5,$what);
		$pdf->Cell(50);
		$pdf->Cell(0,5,$agency);
		$pdf->Ln(20);
		$pdf->Cell(50);
		$pdf->Cell(0,5,$sign_line);
		$pdf->Ln(5);
		$pdf->Cell(50);
		$pdf->Cell(0,5,"Witness                                                              Witness");
	
		
		
		// Unit list if more than 1 unit
		
		if (count($contract->getUnits()) > 1) {

		$pdf->AddPage();
		
		$pdf->Cell(23);
		$pdf->SetFont('Times','',16);
		$pdf->MultiCell(0,5,"Properties");
		
		$pdf->SetY(40);
		$pdf->Cell(50);
		$pdf->SetFont('Times','',11);
		$pdf->MultiCell(0,5,$unit_table_list);
		
		}
		/*
		$pdf->AddPage();
		
		$pdf->SetY(20);
		$pdf->Cell(50);
		$pdf->SetFillColor(224,224,224); //Set background of the cell to be that grey color
		$pdf->Cell(20,12,"P-Ref",1,0,'C',true);  //Write a cell 20 wide, 12 high, filled and bordered, with Order # centered inside, last argument 'true' tells it to fill the cell with the color specified
		$pdf->Cell(20,12,"Unit",1,0,'C',true);
		$pdf->Cell(20,12,"Address",1,0,'C',true);
		$pdf->Cell(20,12,"Floor",1,0,'C',true);
		$pdf->Cell(20,12,"Unit type (Sqm)",1,0,'C',true);
		$pdf->Cell(20,12,"Sale Price",1,1,'C',true); //the 1 before the 'C' instead of 0 in previous lines tells it to move down by the height of the cell after writing this
*/
		
	
		/*
		// Footer
		$pdf->InFooter = true;
		$pdf->SetY(-15);
		$pdf->SetX(60);
		// Times italic 8
		$pdf->SetFont('Times','I',8);
		// Page number
		$pdf->Cell(0,10,'sales@powerhousepropertiesltd.com, www.powerhousepropertiesltd.com',0,0,'C');
		$pdf->InFooter = false;
		*/
	
		if ($contract->getAgreementDate()) {
		$contract_date = $contract->getAgreementDate()->format('Y-m-d');
		} else {
		$contract_date = "";
		}
	
		$path2 = $this->get('kernel')->getRootDir() . '/..';
		
		//if ($this->get('kernel')->getEnvironment() == 'dev') $path2 .= '/web';
			
		$pdf->Output($path2."/contracts/".$contract_date."-".$contract_ref.".pdf","F");
		 
	}
    
    public function createPdfAction() {
    	
    	global $missing;
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	 
    	$contract = $this->admin->getObject($id);
    	
    	if (!$contract) {
    		throw new NotFoundHttpException(sprintf('unable to find the contract with id : %s', $id));
    	}
    	 
    	if (false === $this->admin->isGranted('VIEW', $contract)) {
    		throw new AccessDeniedException();
    	}
    	 
    	$this->admin->setSubject($contract);
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	switch ($contract->getPurpose()->getId()) {
    			case '1':
    				$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Sale Agency Agreement');
    				//$title = "Sale Agency Agreement";
    				$title = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Sale Agency Agreement - Title');
    				$signing = "The Owner";
    				$contract_ref = $contract->getKRef();
    				$this->createPdf($contract, $contract_ref, $text, $title, $signing, 'S');
    				$this->get('session')->setFlash('sonata_flash_success', sprintf('Pdf for the contract %s has been created.', $contract_ref));
    				break;
    			case '2':
    				$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Rental Agency Agreement');
    				//$title = "Rental Agency Agreement";
    				$title = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Rental Agency Agreement - Title');
    				$signing = "The Lessor";
    				$contract_ref = $contract->getKRef();
    				$this->createPdf($contract, $contract_ref, $text, $title, $signing, 'R');
    				$this->get('session')->setFlash('sonata_flash_success', sprintf('Pdf for the contract %s has been created.', $contract_ref));
    				break;
    			case '3':

    				$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Sale Agency Agreement');
    				//$title = "Sale Agency Agreement";
    				$title = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Sale Agency Agreement - Title');
    				$signing = "The Owner";
    				$contract_ref_s = $contract->getKRef().'-S';
    				$this->createPdf($contract, $contract_ref_s, $text, $title, $signing, 'S');

    				$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Rental Agency Agreement');
    				//$title = "Rental Agency Agreement";
    				$title = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Rental Agency Agreement - Title');
    				$signing = "The Lessor";
    				$contract_ref_r = $contract->getKRef().'-R';
    				$this->createPdf($contract, $contract_ref_r, $text, $title, $signing, 'R');
    				
    				$this->get('session')->setFlash('sonata_flash_success', sprintf('Pdf for the contracts %s and %s has been created.',  $contract_ref_s, $contract_ref_r));
    				break;
    		}
    		
    		if ($missing) {
    		//$this->get('session')->setFlash('sonata_flash_error', sprintf('Some fields are missing in the contract : %s.',  implode(", ", $missing)));
    		}
    	
	return $this->redirect($this->admin->generateUrl('edit', array('id' => $id)));
    	
    }
    
    public function createLeasePdfAction() {
    	 
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    
    	$contract = $this->admin->getObject($id);
    	 
    	if (!$contract) {
    		throw new NotFoundHttpException(sprintf('unable to find the contract with id : %s', $id));
    	}
    
    	if (false === $this->admin->isGranted('VIEW', $contract)) {
    		throw new AccessDeniedException();
    	}
    
    	$this->admin->setSubject($contract);
    	 
    	$em = $this->container->get('doctrine')->getEntityManager();
    	 

    			$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Contract - Lease Agreement');
    			$title = "Lease Agreement";
    			$signing = "The Tenant";
    			$contract_ref = $contract->getKRef().'-L';
    			$this->createPdf($contract, $contract_ref, $text, $title, $signing);
    
    			$this->get('session')->setFlash('sonata_flash_success', sprintf('Pdf for the Lease Agreement Contract K%s has been created.',  $contract_ref));
    	 
    	return $this->redirect($this->admin->generateUrl('edit', array('id' => $id)));
    	 
    }
    
    public function ownerEmailAction() {
    	 
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$contract = $this->admin->getObject($id);
    	 
    	if (!$contract) {
    		throw new NotFoundHttpException(sprintf('Unable to find the Contract with id : %s', $id));
    	}
    	 
    	if (false === $this->admin->isGranted('VIEW', $contract)) {
    		throw new AccessDeniedException();
    	}
    	 
    	$this->admin->setSubject($contract);
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    		
    	$email_text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Email - Owner Update Listing');
    	
    	$email_subject = 'Please update your Listing';
    	
    	//$this->get('session')->setFlash('sonata_flash_success', sprintf('Owner email still not implemented!.'));
    
    	$form = $this->createFormBuilder(array('id' => $id, 'status' => '2 - Waiting for owner update'))
    	->add('id', 'hidden')
    	->add('status', 'hidden')
    	->getForm();
    	
    	
    	return $this->render('PHRentalsMainBundle:Admin:email-owner-update-listing.html.twig', array(
    			'action'   => 'ownerEmail',
    			'object'   => $contract,
    			'email_subject' => $email_subject,
    			'email' => $email_text,
    			'form' => $form->createView()
    	));
    
    }
    
    public function statusAction() {
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	 
    	$contract = $this->admin->getObject($id);
    	
    	if (!$contract) {
    		throw new NotFoundHttpException(sprintf('Unable to find the Contract with id : %s', $id));
    	}
    	
    	if (false === $this->admin->isGranted('EDIT', $contract)) {
    		throw new AccessDeniedException();
    	}
    	
    	if ($this->get('request')->getMethod() == 'POST') {
    		
    	$results = $this->get('request')->request->get('form');
    	
    	$contract->setStatus($results['status']);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($contract);
    	$em->flush();
    	
    	$this->get('session')->setFlash('sonata_flash_success', sprintf('Status modified to %s.', $results['status']));
    	}
    	

    	return $this->redirect($this->admin->generateUrl('edit', array('id' => $id)));
    	
    }
    
    public function duplicateAction() {
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$this->get('session')->setFlash('sonata_flash_success', sprintf('Duplicate Action still not implemented!.'));
    	 
    	return $this->redirect($this->admin->generateUrl('edit', array('id' => $id)));
        
    }
    
    public function publishContractAction() {
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$this->get('session')->setFlash('sonata_flash_success', sprintf('Publish Contract Action still not implemented!.'));
    	
    	return $this->redirect($this->admin->generateUrl('edit', array('id' => $id)));
        
    }
    
    public function listingAction() {
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	 
    	$contract = $this->admin->getObject($id);
    	
    	if (!$contract) {
    		throw new NotFoundHttpException(sprintf('Unable to find the Contract with id : %s', $id));
    	}
    	
    	if (false === $this->admin->isGranted('VIEW', $contract)) {
    		throw new AccessDeniedException();
    	}
    	
    	$this->admin->setSubject($contract);
    	 
    	

    	//$contract//
    	
    	$listing = "Internal Use	Generate Thumb	Ref #	K. Ref#	O. Ref#	Active	Class	K 	Priority 	Rating 	Keys At 	Validated By	Validated On	Remarks	Responsive	Featured	Ready Move In	Off Plan	Date Finish	Purpose	Available From	Project	Project-X	Village	Sale Type	Owner Name	First Name	Ownership	City	District	Address	Living Area Size (Sqm)	Land Size (Sqm.)	Sale Price	Rental Long Term	Rental Short Term	Rental Weekly	Rental Daily	Bed	Unit Type	Bath	Distance To Beach (Meter)	Furnished	Swimming Pool	Sea View	Kitchen 	Cooking Hob	Microwave	Fridge	Tv	Safe	A/C	Internet	Security	History	G Mpas Link  	Tagline
";
    	
    	foreach($contract->getUnits() as $contract_unit) {
    		
    		$unit = $contract_unit->getUnit();
    		$owner = $contract->getOwner();
    		   		
    		if($unit->getProject()) {
    			$address = $unit->getProject()->getAddress();
    		} else {
    			$address = $unit->getAddress();
    		}
    	
    	$listing .= $unit->getId()."	";
    	$listing .= ($unit->getGenerateThumbnails()? 'Yes' : 'No')."	";
    	$listing .= $unit->getPRef()."	";
    	$listing .= $contract->getKRef()."	";
    	$listing .= $contract->getOwner()->getOwnerRef()."	";
    	$listing .= ($unit->getActive()? 'Yes' : 'No')."	";
    	$listing .= $unit->getClass()->getName()."	";
    	$listing .= "Yes	";
    	$listing .= "	";
    	$listing .= $unit->getRating()."	";
    	$listing .= $contract_unit->getKeysAtLevel()."	";
    	$listing .= ($contract->getValidatedByUser() ? $contract->getValidatedByUser()->getUsername() : '')."	";
    	$listing .= ($contract->getValidatedOn()? $contract->getValidatedOn()->format('d-M-Y') : '')."	";
    	$listing .= $contract->getRemarks()."	";
    	$listing .= $owner->getResponsive()."	";
    	$listing .= $unit->getFeatured()."	";
    	$listing .= ($unit->getProject() ? 'Yes': 'Yes')."	";
    	$listing .= ($unit->getProject() ? 'No': 'No')."	";
    	$listing .= ($unit->getProject() ? $unit->getProject()->getCompletedOn()->format('M Y') : '')."	";
    	$listing .= $contract->getPurpose()->getName()."	";
    	$listing .= ($contract_unit->getAvailableFrom()? $contract_unit->getAvailableFrom()->format('d-M-Y') : '')."	";
    	$listing .= $unit->getWebTitle()."	";
    	$listing .= ($unit->getProject()? $unit->getProject()->getName() : '')."	";
    	$listing .= ($address->getClass() == 'Village' ? 'Yes' : 'No')."	";
    	
    	
    	$sale_type = "";
    	foreach($owner->getContactTypes() as $type) {
    		if($type->getName() == 'Private Owner') $sale_type = "private sale";
    		if($type->getName() == 'Agency') $sale_type = "via agent";
    		if($type->getName() == 'Developer') $sale_type = "via developer";
    	} 			
    	
    	$listing .= $sale_type."	";
    	$listing .= $owner->getName()."	";
    	$listing .= $owner->getFirstName()."	";
    	$listing .= $unit->getOwnership()."	";
    	$listing .= $address->getDistrict()->getLocation()->getName()."	";
    	$listing .= $address->getDistrict()->getName()."	";
    	$listing .= $address->getText()."	";
    	$listing .= $unit->getLivingArea()."	";
    	$listing .= $unit->getLandSize()."	";
    	$listing .= $contract_unit->getSalePrice()."	";
    	$listing .= $contract_unit->getRental1Year()."	";
    	$listing .= $contract_unit->getRentalMonthly()."	";
    	$listing .= $contract_unit->getRentalWeekly()."	";
    	$listing .= "	";
    	$listing .= $unit->getBedrooms()."	";
    	$listing .= ($unit->getUnitType() ? ($unit->getUnitType()->getName() == '# bedroom(s)'? $unit->getBedrooms().' bedroom'.($unit->getBedrooms()>1?'s':''):$unit->getUnitType()->getName()): "")."	";
    	$listing .= $unit->getBathrooms()."	";
    	$listing .= $address->getDistanceToBeach()."	";
    	$listing .= ($unit->hasTag('fully furnished')? 'Fully' : ($unit->hasTag('partially furnished')? 'Partial' : ($unit->hasTag('not furnished')? '' : '')))."	";
    	$listing .= ($address->hasTag('shared swimming pool')? 'shared swimming pool' : ($address->hasTag('private swimming pool')? 'private swimming pool' : ''))."	";
    	$listing .= ($unit->hasTag('seaview')? 'Yes' : 'No')."	";
    	$listing .= ($unit->hasTag('kitchen')? 'Yes' : 'No')."	";
    	$listing .= ($unit->hasTag('cooking hob')? 'Yes' : 'No')."	";
    	$listing .= ($unit->hasTag('microwave')? 'Yes' : 'No')."	";
    	$listing .= ($unit->hasTag('fridge')? 'Yes' : 'No')."	";
    	$listing .= ($unit->hasTag('tv')? 'Yes' : 'No')."	";
    	$listing .= ($unit->hasTag('safe')? 'Yes' : 'No')."	";
    	$listing .= ($unit->hasTag('a/c')? 'Yes' : 'No')."	";
    	$listing .= ($unit->hasTag('internet')? 'Yes' : 'No')."	";
    	$listing .= ($address->hasTag('security')? 'Yes' : 'No')."	";
    	 
    	
/*

    	Distance To Beach (Meter)
    	Furnished
    	Swimming Pool
    	Sea View
    	Kitchen
    	Cooking Hob
    	Microwave
    	Fridge
    	Tv
    	Safe
    	A/C
    	Internet
    	Security
    	History
    	G Mpas Link
    	Tagline
    	 */
    	
    	
    	
    	$listing .= "
";
    	
    	}
    	 
    	
    	//$this->get('session')->setFlash('sonata_flash_success', sprintf('Owner email still not implemented!.'));
    	 
    	 
    	return $this->render('PHRentalsMainBundle:Admin:contract-listing.html.twig', array(
    			'action'   => 'listing',
    			'object'   => $contract,
    			'listing' => $listing
    	));
    
    }
    
}
?>

