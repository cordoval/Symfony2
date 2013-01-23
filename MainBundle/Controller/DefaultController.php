<?php

namespace PHRentals\MainBundle\Controller;

use PHRentals\MainBundle\Entity\UnitSize;
use PHRentals\MainBundle\Entity\Unit;
use PHRentals\MainBundle\Entity\UnitImage;
use PHRentals\MainBundle\Entity\Location;
use PHRentals\MainBundle\Entity\District;
use PHRentals\MainBundle\Entity\Contact;
use PHRentals\MainBundle\Entity\ContactEmail;
use PHRentals\MainBundle\Entity\ContactProperty;
use PHRentals\MainBundle\Entity\ContactRepresentative;
use PHRentals\MainBundle\Entity\ContactTel;
use PHRentals\MainBundle\Entity\ContactType;
use PHRentals\MainBundle\Entity\Address;
use PHRentals\MainBundle\Entity\Project;
use PHRentals\MainBundle\Entity\Contract;
use PHRentals\MainBundle\Entity\ContractUnit;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAware,
Symfony\Component\HttpFoundation\RedirectResponse;
use PHRentals\MainBundle\Entity\Categorie;

class DefaultController extends ContainerAware
{

    /**
     * @Route("/hello/{name}")
     * @Template()
     */
	
    public function indexAction($name)
    {
        return array('name' => $name);
    }
  
    public function biduleAction() {
    	
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	$units = $em->getRepository('PHRentalsMainBundle:Unit')->findAll();
    	
    	foreach($units as $unit)
    	{
    		//$unit->setSlug($em->getRepository('PHRentalsMainBundle:Unit')->createSlug($unit));
    		
    		$results = array();
    		
    		$dir = __DIR__.'/../../../../../uploaded_file/property/'.$unit->getPRef();
    		
    		if (is_dir($dir)) {
    		$handler = opendir($dir);
    		
	    		// open directory and walk through the filenames
	    		while ($file = readdir($handler)) {
	    		
	    			// if file isn't this directory or its parent, add it to the results
	    			if ($file != "." && $file != "..") {
	    				$results[] = $file;
	    				
	    				$unit_image = new UnitImage;
	    				$unit_image->setName($file);
	    				$unit_image->setPath('uploaded_file/property/1000a001/'.$file);
	    				$unit_image->setUnit($unit);
	    				//$em->persist($unit_image);
	    				$unit->addImage($unit_image);
	    			}
	    		
	    		}
	    		
	    		print($unit->getPRef().": ".implode(", ", $results)."<br/>");
	    		
	    		//$em->persist($unit);
	    		
	    		// tidy up: close the handler
	    		closedir($handler);
    		}
    		else {
    			print($unit->getPRef().": no images<br/>");
    		}
    		
    		
    		
    		//$em->persist($unit);
    	}
    	//$em->flush();
    	
    	/*
$list = array();
$list['PCC0045'] = 10;
$list['PCC0038'] = 14;
$list['PCC0006'] = 16;
$list['PCC0050'] = 18;
$list['PCC0044'] = 300;
$list['PCC0040'] = 36;
$list['PCC0055'] = 53;
$list['PCC0042'] = 38;
$list['PCC0053'] = 39;
$list['PCC0019'] = 276;
$list['PCC0066'] = 42;
$list['PCC0054'] = 47;
$list['PCC0017'] = 49;
$list['PCC0017'] = 50;
$list['PCC0015'] = 278;
$list['PCC0057'] = 55;
$list['PCC0029'] = 314;
$list['PCC0072'] = 447;
$list['PCC0070'] = 323;
$list['PCC0039'] = 327;
$list['PCC0010'] = 94;
$list['PCC0027'] = 95;
$list['PCC0041'] = 96;
$list['PCC0051'] = 97;
$list['PCC0064'] = 98;
$list['PCC0020'] = 426;
$list['PCC0067'] = 59;
$list['PCC0033'] = 118;
$list['PCC0018'] = 133;
$list['PCC0016'] = 134;
$list['PCC0030'] = 138;
$list['PCC0047'] = 353;
$list['PCC0021'] = 354;
$list['PCC0009'] = 148;
$list['PCC0013'] = 154;
$list['PCC0014'] = 155;
$list['PCC0035'] = 156;
$list['PCC0023'] = 164;
$list['PCC0068'] = 364;
$list['PCC0037'] = 168;
$list['PCC0024'] = 372;
$list['PCC0065'] = 373;
$list['PCC0028'] = 374;
$list['PCC0048'] = 420;
$list['PCC0031'] = 187;
$list['PCC0063'] = 281;
$list['PCC0071'] = 188;
$list['PCC0001'] = 381;
$list['PCC0069'] = 193;
$list['PCC0007'] = 425;
$list['PCC0062'] = 393;
$list['PCC0005'] = 203;
$list['PCC0026'] = 204;
$list['PCC0032'] = 205;
$list['PCC0003'] = 422;
$list['PCC0002'] = 210;
$list['PCC0004'] = 214;
$list['PCC0025'] = 216;
$list['PCC0034'] = 401;
$list['PCC0008'] = 219;
$list['PCC0036'] = 221;
$list['PCC0049'] = 222;
$list['PCC0012'] = 263;
$list['PCC0022'] = 229;
$list['PCC0052'] = 255;
$list['PCC0046'] = 256;
$list['PCC0061'] = 122;
$list['PCC0011'] = 261;
    	
    	 
	foreach($list as $key => $value) {
		
		if(is_dir("../ppb/".$key)) {
			rename("../ppb/".$key,"../ppb/".$value);
		} else {
			print("no");
		}
	}
    	
    exit;
    */
    	$message = 'OK.';
    
    	return $this->container->get('templating')->renderResponse('PHRentalsMainBundle:Default:index.html.twig',
    			array('message' => $message)
    	);
    }
    
    public function ajouterUnitsAction() {
        
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
        
        $unit_array = array();     
            $unit_array[] = array('101a','Studio','1st floor','garden view','48','833','140','97','25');
            $unit_array[] = array('101b','Studio','1st floor','private garden','48','833','140','97','25');
            $unit_array[] = array('102','Studio','1st floor','private garden','48','800','150','105','25');
            $unit_array[] = array('103','Studio','1st floor','private garden','48','800','150','105','25');
            $unit_array[] = array('104','Studio','1st floor','private garden','48','800','150','105','25');
            $unit_array[] = array('106a','Studio','1st floor','private garden','48','800','150','105','25');
            $unit_array[] = array('109','Studio','1st floor','direct pool access','60','967','123','129','25');
            $unit_array[] = array('202','Studio','2nd floor','poolside','56','800','150','123','25');
            $unit_array[] = array('203','Studio','2nd floor','poolside','56','800','150','123','25');
            $unit_array[] = array('204','Studio','2nd floor','poolside','56','800','150','123','25');
            $unit_array[] = array('205','Studio','2nd floor','poolside','56','800','150','123','25');
            $unit_array[] = array('206','2 bedrooms','2nd floor','shady side','96','1600','140','123','25');
            $unit_array[] = array('207','Studio','2nd floor','shady side','48','800','150','105','25');
            $unit_array[] = array('208','Studio','2nd floor','shady side','48','800','150','105','25');
            $unit_array[] = array('210','Studio','2nd floor','shady side','48','800','150','105','25');
            $unit_array[] = array('213','1 bedroom','2nd floor','poolside','96','1400','100','63','25');
            $unit_array[] = array('214','2 bedrooms','2nd floor','poolside','150','1933','140','122','25');
            $unit_array[] = array('306','1 bedroom','3rd floor','poolside','81','1233','127','85','25');
            $unit_array[] = array('307','2 bedrooms','3rd floor','shady side','96','1600','140','123','25');
            $unit_array[] = array('311','1 bedroom','3rd floor','poolside','112','1333','110','93','25');
            $unit_array[] = array('401','1 bedroom','4th floor','corner unit/sea view','122','1500','124','90','25');
            $unit_array[] = array('409','1 bedroom','4th floor','corner unit/sea view','112','1600','110','79','25');
            $unit_array[] = array('411','2 bedrooms','4th floor','poolside','165','2267','140','121','25');
            $unit_array[] = array('502','1 bedroom','5th floor','poolside/sea view','112','1500','124','90','25');
            $unit_array[] = array('505','2 bedrooms','5th floor','shady side','96','1600','140','123','25');
            $unit_array[] = array('510','Studio','5th floor','poolside/sea view','48','800','150','123','25');
            $unit_array[] = array('606','2 bedrooms','6th floor','corner unit','96','1600','140','123','25');
            $unit_array[] = array('609','1 bedroom','6th floor','corner unit/sea view','118','1600','110','79','25');
            $unit_array[] = array('703','Studio','7th floor','poolside/sea view','56','967','123','100','25');
            $unit_array[] = array('704','Studio','7th floor','poolside/sea view','48','800','150','123','25');
            $unit_array[] = array('705','1 bedroom','7th floor','poolside/sea view','81','1300','115','76','25');
            $unit_array[] = array('708','Studio','7th floor','shady side','48','800','150','105','25');



        foreach($unit_array as $unit_row) {
        
    	$unit = new Unit;
        
        $unit->setAddress($em->getRepository('PHRentalsMainBundle:Address')->find('2'));
        $unit->setOwner($em->getRepository('PHRentalsMainBundle:Owner')->find('1'));
        
    	$unit->setPRef('1000-'.$unit_row[0]);
        $unit->setRoomNumber($unit_row[0]);
        $unit->setUnitSize($em->getRepository('PHRentalsMainBundle:UnitSize')->findOneBy(array('name' => $unit_row[1])));
        $unit->setUnitClass($em->getRepository('PHRentalsMainBundle:UnitClass')->find('2'));
        
        foreach(explode('/', $unit_row[3]) as $tag) {
            //print($tag);
            //print('='.$em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => $tag))->getName().'/');
                    
        $unit->addTag($em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => $tag)));
        }
        
        $unit->setFloor($unit_row[2]);
        $unit->setLivingArea($unit_row[4]);
        $unit->setBaseRate($unit_row[5]);
        $unit->setBaseTo1d($unit_row[6]/100);
        $unit->setBaseTo1w($unit_row[7]/100);
        $unit->setBaseTo1m('1');
        $unit->setBaseTo3m('1');
        $unit->setBaseTo6m('1');
        $unit->setCheckinTimes('14:00');
        $unit->setCheckoutTimes('10:00');
        $unit->setHighSeason($unit_row[8]/100);
    	
        $em->persist($unit);

        }
        
    	$em->flush();
    
    	$message = 'Units crées avec succès.';
    
    	return $this->container->get('templating')->renderResponse('PHRentalsMainBundle:Default:index.html.twig',
    			array('message' => $message)
    	);
    }
    
    public function enregistrerVariablesAction() {
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	$size_list = array ('studio',
    	'1 bedroom',
    	'2 bedroom',
    	'3 bedroom',
    	'penthouse',
    	'duplex');
    	
    	$i=2;
    	
    	foreach ($size_list as $size) {
    	
    	$categorie1 = new UnitSize();
    	$categorie1->setName($size);
    	//$categorie1->setPosition($i);
    	$em->persist($categorie1);
    $i++;
    	}
    
    	$em->flush();
    
    	$message = 'Unit Sizes cr��es avec succ�s';
    
    	return $this->container->get('templating')->renderResponse('PHRentalsMainBundle:Default:index.html.twig',
    			array('message' => $message)
    	);
    }
    
    public function lireVariablesAction()
    {
    	$em = $this->container->get('doctrine')->getEntityManager();
    	$categories = $em->getRepository('PHRentalsMainBundle:UnitSize')->findAll();
    
    	return $this->container->get('templating')->renderResponse('PHRentalsMainBundle:Default:lireVariables.html.twig',array(
    		 'categories' => $categories)
    	);
    }
    
    public function importDistrictsAction() {
    
    	$em = $this->container->get('doctrine')->getEntityManager();
    
    	// get file
    	 
    	$handle = fopen("districts.txt","r" );
    	$i = 1;
    	while ($line=fgets($handle))
    	{
    		$data = array();
    		list($data['location'], $data['district']) = explode(";", $line);
    			
    		print("<br/>".$i. " : ". $data['location'] ."/". $data['district']);
    		$i++;
    		$data = array_map('trim', $data);
    		
    		$location = $em->getRepository('PHRentalsMainBundle:Location')->findOneBy(array('name' => $data['location']));
    		
    		if (!$location) {
    			$location = new Location;
    			$location->setName($data['location']);
    			$em->persist($location);
    			$em->flush();
    		}
    		
    		$district = $em->getRepository('PHRentalsMainBundle:District')->findOneBy(array('name' => $data['district']));
    		
    		if (!$district) {
    			$district = new District;
    			$district->setName($data['district']);
    			$district->setLocation($location);
    			$em->persist($district);
    			$em->flush();
    		}
    	}
    	
    }
    
    public function importTempAction() {
    
    	$em = $this->container->get('doctrine')->getEntityManager();
    
    	// get file
    	
    	//$handle = fopen("condos.txt","r" );
    	$handle = fopen("contract_units.txt","r" );
    	
    	
    	$i = 2;
    	$log = "";
    	
    	$last_unit = new Unit;
    	
    	// skip first line
    	$line=fgets($handle);
    	
    	while ($line=fgets($handle))
    	{
    		//list($oRef, $oRefOld, $isAgency, $isDeveloper, $isCompany, $isPrivate, $contact, $representative, $address, $tel_head, $tel_office, $tel_fax, $tel_mobile, $email, $class, $kRef, $kdate, $pRef, $commission, $property, $purpose,  $project_unit, $project_address, $remarks, $data_source) = explode(";", $line);
    		$data = array();
    		//list($data['Generate Thumb'], $data['Ref #'], $data['K. Ref#'], $data['O. Ref#'], $data['Active'], $data['Class'], $data['K'], $data['Priority'], $data['Rating'], $data['Keys At'], $data['Validated By'], $data['Validated On'], $data['Remarks'], $data['Responsive'], $data['Featured'], $data['Ready Move In'], $data['Off Plan'], $data['Date Finish'], $data['Purpose'], $data['Available From'], $data['Project'], $data['Project-X'], $data['Village'], $data['Sale Type'], $data['Owner Name'], $data['First Name'], $data['Ownership'], $data['City'], $data['District'], $data['Address'], $data['Living Area Size (Sqm)'], $data['Land Size (Sqm.)'], $data['Sale Price'], $data['Rental Long Term'], $data['Rental Short Term'], $data['Rental Weekly'], $data['Rental Daily'], $data['Bed'], $data['Unit Type'], $data['Bath'], $data['Distance To Beach (Meter)'], $data['Furnished'], $data['Swimming Pool'], $data['Sea View'], $data['Kitchen'], $data['Cooking Hob'], $data['Microwave'], $data['Fridge'], $data['Tv'], $data['Safe'], $data['A/C'], $data['Internet'], $data['Security'], $data['History'], $data['G Mpas Link'], $data['Tagline']) = explode(";", $line);
			
    		list($data['Ref #'], $data['K. Ref#'], $data['Validated By'], $data['Validated On'], $data['Remarks'], $data['Purpose'], $data['Sale Price'], $data['Rental Long Term'], $data['Rental Short Term'], $data['Rental Weekly'], $data['Rental Daily']) = explode(";", $line);
    		
    		$data = array_map('trim', $data);
    		
    		echo "<br/>".$i. " : ". $data['K. Ref#']. " : ".$data['Ref #'];
    		$i++;
    		
    		//if($i==15) { exit; }
    		
    		$unit = $em->getRepository('PHRentalsMainBundle:Unit')->findOneBy(array('pRef' => $data['Ref #']));
    		
    		
    		if ($unit) {
    			echo " Unit ok	";
    		}
    		else {
    			echo " Unit NOT FOUND	";
    		}
    		
    		
    		
    		$contract = $em->getRepository('PHRentalsMainBundle:Contract')->findOneBy(array('kRef' => $data['K. Ref#']));
    		
    		$user = $this->container->get('security.context')->getToken()->getUser();
    		
    		if ($contract) {
    			echo "Contract ok";
    			
    			$contract_unit = $em->getRepository('PHRentalsMainBundle:ContractUnit')->findOneBy(array('contract' => $contract, 'unit' => $unit));
    			if (!$contract_unit) {
    				echo "Contract Unit NOT FOUND";
    			}
    		}
    		// deal with units with XXXXa001, XXXXa002
    		elseif (substr($last_unit->getPRef(),0,4) == substr($data['Ref #'],0,4)) {
    				
    				$last_contract_unit = $em->getRepository('PHRentalsMainBundle:ContractUnit')->findOneBy(array('unit' => $last_unit));
    				$contract = $last_contract_unit->getContract();
    				
    				$contract_unit = new ContractUnit;
    				$contract_unit->setContract($contract);
    				$contract_unit->setUnit($unit);
    				$contract->addUnit($contract_unit);
    				
    				
    			} else {

    			echo "Contract NOT FOUND";
    			
    			$contract = new Contract;

    			$contract->setKRef($this->container->get('doctrine')->getRepository('PHRentalsMainBundle:Contract')->findNextRef());
    			$contract->setCreatedByUser($user);
    			$date = new \DateTime('2012-01-01');
    			$contract->setCreatedOn($date);
    			$contract->setOwner($unit->getOwner());
    			$contract->setOrigin('old system');
    			
    			$contract->setStatus($this->container->get('doctrine')->getRepository('PHRentalsMainBundle:ContractStatus')->find('9'));
    			 
    			$contract_unit = new ContractUnit;
    			$contract_unit->setContract($contract);
    			$contract_unit->setUnit($unit);
    			$contract->addUnit($contract_unit);
    			
    			//$em->persist($contract);
    			//$em->persist($contract_unit);
    			//$em->flush();
    		}
    		
    		// FOR ALL
    		
    		$date = new \DateTime('now');
    		
    		$contract->setUpdatedByUser($user);
    		$contract->setUpdatedOn($date);
    		
    		if (!$contract->getAgreementDate()) {
    		$date = new \DateTime('2012-01-01');
    		$contract->setAgreementDate($date);
    		}
    		
    		if($data['Purpose'] && !$contract->getPurpose()) {
    			$contract->setPurpose($em->getRepository('PHRentalsMainBundle:ContractPurpose')->findOneBy(array('name' => $data['Purpose'])));
    		}
    		
    		$validating_user = $em->getRepository('ApplicationSonataUserBundle:User')->findOneBy(array('username' => $data['Validated By']));
    		 
    		if($validating_user && !$contract->getValidatedByUser()) {
    			$contract->setValidatedByUser($validating_user);
    		}
    		
    		$validating_date = \DateTime::createFromFormat('d/m/Y', $data['Validated On'], new \DateTimeZone('UTC'));
    		 
    		if ($validating_date) {
    			$validating_date->setTime(0,0,0);
    			$contract->setValidatedOn($validating_date);
    		}
    			
			if ($data['Remarks']) {
				$contract->setRemarks($data['Remarks'].' '.$contract->getRemarks());
			}

    		if($data['Sale Price']>0 && !$contract_unit->getSalePrice()) {
    			$contract_unit->setSalePrice($data['Sale Price']);
    		}
    		
    		if($data['Rental Long Term']>0 && !$contract_unit->getRental1Year()) {
    			$contract_unit->setRental1Year($data['Rental Long Term']);
    		}
    		if($data['Rental Short Term']>0 && !$contract_unit->getRentalMonthly()) {
    			$contract_unit->setRentalMonthly($data['Rental Short Term']);
    		}
    		if($data['Rental Weekly']>0 && !$contract_unit->getRentalWeekly()) {
    			$contract_unit->setRentalWeekly($data['Rental Weekly']);
    		}
    		
    		//$em->persist($contract);
    		//$em->persist($contract_unit);
    		//$em->flush();
    		
    		$last_unit = $unit;
    		
    				/*
    			if ($data['K Date']) {
    			$date = \DateTime::createFromFormat('d/m/Y', $data['K Date'], new \DateTimeZone('UTC'));
    			}
    			else {
    			$date = new \DateTime('2012-01-01');
    			}
    			$contract->setAgreementDate($date);
    			
    			$contract->setStatus($this->container->get('doctrine')->getRepository('PHRentalsMainBundle:ContractStatus')->find('4'));
    			
    			$contract->setUpdatedByUser($user);
    			$contract->setUpdatedOn($date);

    			if (!$unit->getNum()) {
    				$unit->setNum($data['Address']);
    			}
    			
    			$contract->setRemarks($data['Problem']);
    			
    			if ($data['%'] > 0) {
    			$contract->setAgencyFee($data['%']);
    			}
    			
    			if ($data['%'] <= 5) {
    				$contract->setCommission('Regular');
    			}
    			if ($data['%'] < 5) {
    				$contract->setCommission('Premium');
    			}
    			
    			
    			 
    			$em->persist($contract);
    			$em->persist($unit);
    			 
    			$em->flush();
    			
    		*/
    		
/*
    		$data['%']
    		$data['Project name']
    		$data['Address']
    		$data['Purpose']
    		$data['K Date']
    		$data['Location']
    		$data['Problem']
    		$data['Validation']
    		*/
    		
    		
    		/*
    		// Create Unit
    		$unit = new Unit;
    		$unit->setPRef($data['Ref #']);
    		
    		if ($data['Generate Thumb'] == 'No') {    		
    			$unit->setGenerateThumbnails(false);
    		} else {
    			$unit->setGenerateThumbnails(true);
    		}
    		
    		if ($data['Active'] == 'No') {
    			$unit->setActive(false);
    		} else {
    			$unit->setActive(true);
    		}
    		
    		$unit->setRating($data['Rating']);
    		
    		//$unit->setRemarks($data['Remarks']);
    		
    		if ($data['Featured'] == 'Yes') {
    			$unit->setFeatured(true);
    		} else {
    			$unit->setFeatured(false);
    		}

    		if ($data['Off Plan'] == 'Yes') {
    			$unit->setPropertyStatus("Off-plan");
    		} else {
    			$unit->setPropertyStatus("Ready");
    		}
    		
    		$unit->setWebTitle($data['Project']);
    		
    		$unit->setOwnership($data['Ownership']);
    		   		
    		$unit->setLivingArea($data['Living Area Size (Sqm)']);
    		
    		$unit->setLandSize($data['Land Size (Sqm.)']);
    		
    		if ($data['Bed'] == '1' || $data['Bed'] == '2' || $data['Bed'] == '3' || $data['Bed'] == '4') {
    			$unit->setBedrooms($data['Bed']);
    			$unit->setSleeps($data['Bed']*2);
    			$unit->setUnitType($em->getRepository('PHRentalsMainBundle:UnitSize')->findOneBy(array('name' => '# bedroom(s)')));
    		} else {
    			$size = $em->getRepository('PHRentalsMainBundle:UnitSize')->findOneBy(array('name' => $data['Bed']));
    			if ($size) {
    				$unit->setUnitType($size);
    			}    			
    		}
    		
    		$unit->setBathrooms($data['Bath']);
    		
    		$unit->setDescription($data['Tagline']);
    				
    		if($data['Furnished'] == 'Fully') {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "fully furnished"));
    			$unit->addTag($tag);
    		}
    		
    		if($data['Furnished'] == 'Partial') {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "partially furnished"));
    			$unit->addTag($tag);
    		}
    		
    		if($data['Furnished'] == 'No') {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "not furnished"));
    			$unit->addTag($tag);
    		}
    		
    		if($data['Sea View'] == "Yes") {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "kitchen"));
    			$unit->addTag($tag);
    		}
    		if($data['Kitchen'] == "Yes" || $data['Furnished'] == 'Fully') {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "sea view"));
    			$unit->addTag($tag);
    		}
    		if($data['Cooking Hob'] == "Yes" || $data['Furnished'] == 'Fully') {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "cooking hob"));
    			$unit->addTag($tag);
    		}
    		if($data['Microwave'] == "Yes") {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "microwave"));
    			$unit->addTag($tag);
    		}
    		if($data['Fridge'] == "Yes" || $data['Furnished'] == 'Fully') {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "fridge"));
    			$unit->addTag($tag);
    		}
    		if($data['Tv'] == "Yes") {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "tv"));
    			$unit->addTag($tag);
    		}
    		if($data['Safe'] == "Yes") {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "safe"));
    			$unit->addTag($tag);
    		}
    		if($data['Internet'] == "Yes") {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "internet"));
    			$unit->addTag($tag);
    		}		
    		
    		if(($data['A/C'] != "" && $data['A/C'] != "No") || $data['Furnished'] == 'Fully') {
    			$tag = $em->getRepository('PHRentalsMainBundle:UnitTag')->findOneBy(array('name' => "a/c"));
    			$unit->addTag($tag);
    		}	
    		
    		// PROJECT
    		
    		$project = $em->getRepository('PHRentalsMainBundle:Project')->findOneBy(array('name' => $data['Project-X']));
    		
    		if ($project) {
    			
    			$unit->setProject($project);
    			$project->setCompletedOn($data['Date Finish']);
    			$address = $project->getAddress();
    			
    			echo "<br/>".$i. " : ". $data['Ref #'];
    			echo  " - Project ".$data['Project-X']. " FOUND";
    			
    			} else {
    				//if($data['Village'] == 'Yes') {
    				echo "<br/>".$i. " : ". $data['Ref #'];
    				echo  " - Project ".$data['Project-X']. " NOT FOUND";
    				//}
    				$address = new Address;
    				$unit->setAddress($address);
    				$address->setText($data['Project-X']);
    				
    			}

    			$address->setDistanceToBeach($data['Distance To Beach (Meter)']);
    			
    			if (!$address->getDistrict()) {
    				$district = $em->getRepository('PHRentalsMainBundle:District')->findOneBy(array('name' => $data['District']));
    				if ($district) {
    					$address->setDistrict($district);
    				}
    			}
    			
    			$address->setClass($em->getRepository('PHRentalsMainBundle:AddressClass')->findOneBy(array('name' => $data['Class'])));
    			
    			if($data['Village'] == 'Yes') {
    			$address->setClass($em->getRepository('PHRentalsMainBundle:AddressClass')->findOneBy(array('name' => 'Village')));
    			}
    			if($data['Village'] == 'No') {
    				$address->setClass($em->getRepository('PHRentalsMainBundle:AddressClass')->findOneBy(array('name' => 'Standalone house')));
    			}
    			
    			$address->setText($data['Address']);
    			
    			if ($data['Swimming Pool'] == "Communal") {
    				$tag = $em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => "shared swimming pool"));
    				$address->addTag($tag);
    			}
    			if ($data['Swimming Pool'] == "Private" || $data['Swimming Pool'] == "Yes") {
    				$tag = $em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => "private swimming pool"));
    				$address->addTag($tag);
    			}
    			if($data['Security'] == "Yes") {
    				$tag = $em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => "security"));
    				$address->addTag($tag);
    			}
    			

    		 
    		// CONTACT
    		
    		$owner = $em->getRepository('PHRentalsMainBundle:Contact')->findOneBy(array('name' => $data['Owner Name']));
    		
    		if ($owner) {
    			 
    			//echo " - ".$project->getName();
    			$unit->setOwner($owner);
    			
    			$owner->setResponsive($data['Responsive']);
    			
    			if ($data['O. Ref#']) {
	    			if (!$owner->getOwnerRef()) {
	    				$owner->setOwnerRef($data['O. Ref#']);
	    				echo "<br/>".$i. " : ". $data['Ref #'];
	    				echo  " - Owner Ref ".$data['O. Ref#']. " SET";
	    			}
	    			
	    			if ($owner->getOwnerRef() != $data['O. Ref#']) {
	    				//echo "<br/>".$i. " : ". $data['Ref #'];
	    				//echo  " - Owner Ref ".$data['O. Ref#']. " DIFFERENT IN DATABASE : ".$owner->getOwnerRef();
	    			}
    			}
    			 
    		} else {
    			echo "<br/>".$i. " : ". $data['Ref #'];
    			echo  " - Owner ".$data['Owner Name']. " NOT FOUND";
    			 
    		}
    		
    		// CONTRACT
    		
    		if ($data['K. Ref#']) {
    		
	    		$contract = $em->getRepository('PHRentalsMainBundle:Contract')->findOneBy(array('kRef' => $data['K. Ref#']));
	    		
	    		if(!$contract) {
	    		$contract = new Contract;
	    		$contract->setKRef($data['K. Ref#']);
	    		}
	    		
	    		if(!$contract->getOwner()) $contract->setOwner($owner);
	    		
	    		$contract->setStatus($em->getRepository('PHRentalsMainBundle:ContractStatus')->findOneBy(array('name' => '3 process not initiated yet')));

	    		$contract->setRemarks($data['Remarks']);
	    		
	    		$contract_unit = new ContractUnit;
	    		$contract_unit->setContract($contract);
	    		$contract_unit->setUnit($unit);
	    		$contract_unit->setKeysAtText($data['Keys At']);
	    		
	    		$user = $em->getRepository('ApplicationSonataUserBundle:User')->findOneBy(array('username' => $data['Validated By']));
	    		
	    		if($user) $contract->setValidatedByUser($user);
	    		
	    		$date = \DateTime::createFromFormat('d/m/Y', $data['Validated On'], new \DateTimeZone('UTC'));
	    		
	    		if ($date) {
	    			$date->setTime(0,0,0);
	    			$contract->setValidatedOn($date);
	    		}
	    		
	    		if($data['Purpose']) {
	    			$contract->setPurpose($em->getRepository('PHRentalsMainBundle:ContractPurpose')->findOneBy(array('name' => $data['Purpose'])));
	    		}
	    		
	    		if($data['Sale Type']) {
	    			$contract_unit->setSaleType($data['Sale Type']);
	    		}
	    		if($data['Sale Price']) {
	    			$contract_unit->setSalePrice($data['Sale Price']);
	    			if ($data['Living Area Size (Sqm)'] > 0) {
	    				$persqm = round($data['Sale Price']/$data['Living Area Size (Sqm)'],2);
	    			}
	    			if ($data['Land Size (Sqm.)'] > 0) {
	    				$persqm = round($data['Sale Price']/$data['Land Size (Sqm.)'],2);
	    			}
	    			if ($persqm>0) {
	    				$contract_unit->setSalePricePerSqm($persqm);
	    			}
	    		}
	    		
	    		$date = \DateTime::createFromFormat('d/m/Y', $data['Available From'], new \DateTimeZone('UTC'));
	    		 
	    		if ($date) {
	    			$date->setTime(0,0,0);
	    			$contract_unit->setAvailableFrom($date);
	    		}
	    		
	    		$contract_unit->setRental1Year($data['Rental Long Term']);
	    		$contract_unit->setRentalMonthly($data['Rental Short Term']);
	    		$contract_unit->setRentalWeekly($data['Rental Weekly']);

    		}
    		*/
    		
    		/*
    		$data['K']
    		$data['Priority']
    		$data['Remarks']
    		
    		$data['Ready Move In']
    		
    		$data['Rental Daily']

    		$data['History']
    		$data['G Mpas Link']
    		
    		*/
	    		
    		/*
	    			$em->persist($unit);
	    			if($project) {
	    			$em->persist($project);
	    			} else {
	    			$em->persist($address);
	    			}
	    			$em->persist($owner);
	    			if ($data['K. Ref#']) {
		    			$em->persist($contract);
		    			$em->persist($contract_unit);
	    			}
	    			$em->flush();
    		*/
    	}
    	
    	//$em->flush();
    	
    	//print($log);
    	exit;
    	
    	$message = 'Units crées avec succès.';
    	
    	return $this->container->get('templating')->renderResponse('PHRentalsMainBundle:Default:import.html.twig',
    			array('message' => $message)
    	);
    
    }
    
    public function checkAddressAction() {
    
		$em = $this->container->get('doctrine')->getEntityManager();
    
    	// get file
    	
    	$handle = fopen("projects.txt","r");
    	$i = 2;
    	$not=0;
    	
    	// skip first line
    	$line=fgets($handle);
    	
    	$log = "Go!";
    	
    	while ($line=fgets($handle))
    	{
    		//list($oRef, $oRefOld, $isAgency, $isDeveloper, $isCompany, $isPrivate, $contact, $representative, $address, $tel_head, $tel_office, $tel_fax, $tel_mobile, $email, $class, $kRef, $kdate, $pRef, $commission, $property, $purpose,  $project_unit, $project_address, $remarks, $data_source) = explode(";", $line);
    		$data = array();
    		list($data['district_id'], $data['name'], $data['type'], $data['adr_street_1'], $data['adr_street_2'], $data['adr_street_3'], $data['adr_street_4'], $data['adr_street_5'], $data['adr_street_6'], $data['adr_city'], $data['adr_province'], $data['adr_zip'], $data['adr_country'], $data['createdAt'], $data['updatedAt']) = explode(";", $line);
			
    		$log .= "<br/>".$i. " : ". $data['name'];
    		$i++;
    		
    		//if($i==200) { exit; }
    		   		
    		$data = array_map('trim', $data);
    		
    		$project = $em->getRepository('PHRentalsMainBundle:Project')->findOneBy(array('name' => $data['name']));
    		 
    		if ($project) {
    			$log .= " - FOUND";
    			
    			
    			
    			
    			$project->getAddress()->setClass($em->getRepository('PHRentalsMainBundle:AddressClass')->find($data['type']));
				$project->getAddress()->setDistrict($em->getRepository('PHRentalsMainBundle:District')->find($data['district_id']));
				$project->getAddress()->setAdrStreet1($data['adr_street_1']);
				$project->getAddress()->setAdrStreet2($data['adr_street_2']);
				$project->getAddress()->setAdrStreet3($data['adr_street_3']);
				$project->getAddress()->setAdrStreet4($data['adr_street_4']);
				$project->getAddress()->setAdrStreet5($data['adr_street_5']);
				$project->getAddress()->setAdrStreet6($data['adr_street_6']);
				$project->getAddress()->setAdrCity($data['adr_city']);
				$project->getAddress()->setAdrProvince($data['adr_province']);
				$project->getAddress()->setAdrZip($data['adr_zip']);
				$project->getAddress()->setAdrCountry($data['adr_country']);
				
				$date = \DateTime::createFromFormat('Y-m-d H:i:s', $data['createdAt'], new \DateTimeZone('UTC'));
				$date->setTime(0,0,0);
				
				$project->getAddress()->setCreatedOn($date);
				$project->getAddress()->setUpdatedOn($date);
				$em->persist($project);
				$em->flush();
    			
    			
    		} else {
    			$log .= " - NOT FOUND";
    			$not++;
    		}	
    	}	
    	
    	print($log);
    	
    	print("<br>".$not." NOT FOUND");
    	
		exit;
    }
    
    public function checkTypesAction() {
    	
    	$agents = array('Julia','Tom Dallyn','PongsakDanurak','Tom Courtney','John Farr','Vareenjinda Co., Ltd.','Shining Light','Arun Sapthai','Beach Properties Thailand','Suppaluck Kruttharam','Chanit Kulyut','Pongsak Danurak','Jukarat Ruangratanakorn','Tadarawadi','Yupaporn Sangpagdee','Suchat Chanchiawwichai','Jo Stetten','Jirut Rattanaprathipthong','Colin De Jong','Tony\'s Property','AAAA Group', 'ABC Global', 'Absolute Real Estate', 'Absolute World', 'ACI-Ocean Properties', 'Acqua Condominium', 'Acute Realty', 'Ad Condo', 'AG International Property Group Co., Ltd', 'Alan Bolton Property Consultants', 'Alec Seycina', 'Alex', 'Alex Sevidov', 'All Thailand Properties', 'Alpha Realty Pattaya', 'Amari Residence', 'Amazon', 'Ananya', 'Andy', 'Angel Heart Realty Co. Ltd.', 'Angket Hip Residence', 'Anny', 'ANS Thailand Real Estate', 'Anttommo', 'Apus', 'Arise Asia', 'Art on Hill', 'Asia Club Business Travel', 'Asia Property World', 'Atlantis Resort', 'Avion Property Pty Ltd.', 'Axiom Smart Properties', 'Azure Overseas', 'Baan Pictory', 'Baan Thai Property', 'Bangkok Property', 'BDO Advisory Ltd', 'Beach Front Jomtien Residence', 'Beach Front Pattaya Property', 'Beach Properties Thailand', 'Beach Properties Thailand', 'Beli Slon', 'Benchmark', 'Benchmark', 'Best Property in Thailand', 'Big Mango Properties', 'Big Mango Properties', 'Big Mango Properties', 'Biz House', 'Blue Orange Asia', 'Blue Vision Agency', 'Bobby Brooks', 'Boren Menachem', 'Boris', 'Brettraa', 'Buy Thai Properties', 'Buy Thai Properties', 'Buy Thai Properties', 'C View', 'Capital One International Co., Ltd.', 'Capital TV', 'Capitalise Investments', 'Casa Tara', 'CBA', 'CCR Property', 'Centara Avenue', 'Centara Grand Residence', 'Center Estate Agent', 'Center Estate Agent', 'Century 21 B2 Real Estate', 'Century 21 Thailand', 'Cetus Beachfront', 'Chart', 'Chatchanan', 'Chin', 'City and Urban', 'City Center Residence', 'City Garden', 'Clare Pattaya Property', 'Club Royal', 'Coastal Property', 'Coastal Real Estate', 'Colliers', 'Colliers', 'Colliers', 'Colossal Property Investments', 'Compass', 'Condo One X', 'Contrast Investments', 'Cowp', 'Crown Well', 'Daniel', 'David', 'David B', 'David Miller', 'David Nuta', 'De Blue', 'Delight Real Estate', 'Developer Direct', 'Developer Direct', 'Diamond Business Group', 'Diamond Realty', 'Dimond Home', 'DMC Inter Law-Pattaya', 'Domain Property Services', 'Domru Anton', 'Domum Meridiem', 'Dragonart Media', 'Dusit Grand Condo View', 'East Coast Real Estate', 'East Coast Real Estate', 'East West Developments', 'Egypt property', 'Elad Bryn', 'Engel & Voelkers', 'Ensign Media', 'Estates Alliance', 'Euro Asia Development', 'Executive Residence 3/4/5', 'Exel Real Estate', 'Exotiq Real Estate', 'Expat Services', 'Fair Properties', 'Farang Property Services', 'Farang Property Services', 'Father Niranjan', 'First Stop Property', 'Five Star Villas And Condos Jomtien', 'Five Star Villas And Condos Pratumnak', 'Fortuna Thai', 'Frank van der Heijden', 'Global Property Insurance', 'Global Property Insurance', 'Global Property Solutions', 'Global Thai Company', 'Gol.Den Group Property', 'Golden Homes Real Estate', 'Grand Caribbean Condo', 'Grand Caribbean Condo', 'Green Door Enterprises', 'Green Door Enterprises', 'Gurlz Group', 'Hamptons Advance Solutions', 'Happy Homes', 'Harrison Public Co., Ltd.', 'Harry & Sons Co., Ltd.', 'Henry Realty', 'Herman van gucht', 'Hleba', 'Home Properties', 'Hot Pattaya', 'Hyde Park 1', 'Hyde Park 2', 'Ideal Property Solutions', 'Iguana Group', 'IM Property Pattaya', 'InfoCity', 'Info-HAS', 'IQPC Worldwide Pte Ltd', 'Irina', 'ISS Word Wide', 'Iwona Kalwarcyzk', 'Jed Realty', 'Jesper', 'Jomtien Beach & Mountain P6', 'Jomtien Plaza Residence', 'Kaew', 'Kannika', 'Karsten Sueggel', 'KCR Homefinder', 'Kim Property Real Estate', 'Kinetic Business Solutions', 'Knight Knox International', 'Knight Knox International', 'Knight Knox International', 'Knight Knox International', 'Knight Knox International', 'KP Thailand', 'Ladnongkun', 'Laguna Bay', 'Laguna Beach Jomtien', 'Laguna Beach Jomtien 2', 'Laguna Height Longbeach', 'Land Of Smile Real Estate', 'Les Smithers', 'Limcharoen Hughes & Glanville', 'LK Legend', 'Manasnan', 'Marina View', 'Mark', 'MartinCox/ martin soccer/ Maryam Sattar', 'Mathias', 'Mcinnes Corporation Co., Ltd', 'Michael Lospp', 'MIPIM Asia', 'Mirage Real Estate', 'Modus Condo', 'Montari Jomtien', 'Movenpick White Sand', 'MPB Property', 'Multi Estate', 'My Home Abroad', 'My Thai Home', 'My Thai Home', 'Nam Talay', 'Nazz Homes Living Bangkok', 'Neo Condo', 'Neo Seaview Condo', 'New Wave Pattaya', 'Nikolic Enterprises Pty Ltd', 'Noirich Real Estate', 'Northern Thai Realty', 'Northern Thai Realty', 'Northern Thai Realty', 'Northern Thai Realty', 'Northpoint', 'Northpoint R', 'Northpoint R', 'Northpoint R', 'Northshore Property', 'Northshore Property', 'Nova Ocean View', 'Novana Residence', 'Objecta - Immobilien - Real Estate - Property in Thailand', 'Ocean Portofino', 'Ocean Residential Property', 'Ocean San Marino', 'Ocean San Marino', 'Olga Romanova', 'One Stop Real Estate', 'Optisource Asia', 'Orestone Group Co,Ltd', 'Overseas Property Investments', 'Paolo Pompei', 'Paradise City Property', 'Paradise City Property', 'Paradise Park', 'Paradise Realty', 'Paragon Properties', 'Paragon Properties', 'Paragon Properties', 'Park Lane', 'Park Royal 1', 'Park Royal 2', 'Park Royal 3', 'Pascal Zollinger', 'Pattaya Agency', 'Pattaya City Resort', 'Pattaya Condo Invesments', 'Pattaya Condo Studio Villas House For Rent And Sale', 'Pattaya Estate Agents', 'Pattaya General', 'Pattaya Grad', 'Pattaya Heights', 'Pattaya Holiday Property', 'Pattaya House & Condos', 'Pattaya Jomtien Property', 'Pattaya Ocean Property/Patterson MGMT Co. /B.D.C. Patterson Management Ltd.', 'Pattaya Prestige Properties', 'Pattaya Properties', 'Pattaya Property', 'Pattaya Property Adviser', 'Pattaya Property Agents', 'Pattaya Realty', 'Pattaya Realty', 'Pattaya Realty – Pattaya Land', 'Pattaya Unique Properties', 'PBC Real Estate', 'Peter', 'Phaninthapanya', 'Pinea', 'Plan Siam Pro', 'Pongstorn Sangruchi', 'Premier International', 'Premier International', 'Prima Residence', 'Primavera', 'Property Finder', 'Property Marketing Specialists (jomtien) Co., Ltd.', 'Property Marketing Specialists (jomtien) Co., Ltd.', 'Property Partners Asia', 'Property Report', 'Property Showrooms', 'Propnex Property Networks', 'Proven Projects', 'Raimon Land', 'Ratdawan', 'Real Estate Club Thailand', 'Reflection Jomtien', 'Rental Plus and Marketing', 'Rightmove', 'Royal Heights', 'Royale Du Maroc', 'Russian House Real Estate', 'Russian Pattaya', 'Russkiy Dom', 'Sallmanns', 'Sallmanns', 'Savills', 'Savills', 'Savills', 'Scandic Property', 'Scandinavian Homes Ltd', 'Scandinavian Sales Center', 'SDPC Property Consultants', 'Sea Breeze Thai Properties', 'Seaboard Properties', 'Sean Tinsley', 'Seek and Buy Properties Overseas', 'Sergey Segal', 'Siam Developments', 'Siam Home', 'Siam Properties', 'Siam Real Estate', 'Siam Real Estate', 'Siam Residence', 'Silvermover', 'Sixty Six', 'Sky', 'Skylight', 'Soho Properties', 'Srirat', 'Star Siam Enterprise Co., Ltd', 'Starhill Realty - Property Investment Specialists', 'Stefano Parisse', 'Stuart Foulkes', 'Sunny Pattaya', 'Sunset Blvd.', 'Super Consultants', 'Svetlana', 'T Plus Property Pattaya ', 'Talay Real Estate', 'Terry\'s Thai Property', 'Thai Accounting', 'Thai Business Help', 'Thai Business Lawyers', 'Thai Estate Agents', 'Thai Gringo', 'Thai Home Pattaya Property', 'Thai Home Property', 'Thai House', 'Thai Invest', 'Thai Legal & Associates', 'Thai Living', 'Thai Property Guide', 'Thai Sunshine Developments', 'Thaihus', 'ThaiImmo Pattaya', 'Thailand Property Magazine', 'Thailand Property-Pattaya', 'Thanakorn', 'The Cliff', 'The Cliff', 'The Cove', 'The Cove', 'The Fifth', 'The Gallery', 'The Koral', 'The Ocean Pearl', 'The Palms', 'The Palms', 'The Paradise Residence', 'The Peak', 'The Peak', 'The Residence', 'The Retreat', 'The Urban', 'The View', 'The Vision', 'The Water Park', 'Thoy Wellenhoffer', 'Tilleke & Gibbons International', 'Timothy', 'TLP Tour', 'Tony\'s Ptry. Dev. Group', 'Top Property Real Estate', 'Top Well Property Co., Ltd', 'Town & Country Property', 'Town & Country Property', 'Town & Country Property', 'Town & Country Property', 'Tristant', 'Tropical Dream', 'Tropical Dream', 'Tropicana Condotel', 'Tudor Court', 'Urbaan Real Estate', 'Violet Home Loans Australia Pty Ltd', 'VIP Property', 'VIP Real Estate', 'VIP Real Estate Co., Ltd', 'Ward Consulting', 'Waterfront Suites & Residences', 'Waters Edge', 'Whole World of Property', 'Wilson Land and Property', 'Windsor Homes', 'Wongamat Tower', 'Woranooch Nianchaona', 'World Wide Group', 'Y. K. Sam & Yury Kolobov', 'Yakovi', 'Ying', 'Yorkie', 'Yui', 'Yuriy', 'Zen', 'Zire', 'Areeya Villa', 'Baan Bangsaray', 'Ban Dhewaran', 'Baan Sirisa 16', 'Beverly Hills', 'Custom Homes', 'Family Hills', 'Horseshoe Point/House', 'Huay Yai Villas', 'Lapttana', 'Movenpick White Sand Beach', 'New Nordic', 'Nibbana Shade', 'Pheonix Palms', 'Ratanakorn Asset', 'Riverside park', 'Royale Du Maroc', 'Seabreeze', 'SP Townhome', 'Tadarawadi', 'Talay Sawan', 'Talay Sawan', 'Thailand Holiday Homes', 'Viewtalay Marina');
    	
		$private = array('Mark Gillian', 'John Farr', 'Jung', 'Mukesh Thakkar', 'Suppaluck Kruttharam', 'Aldo Licandro', 'Julia', 'Eric Burq', 'Goran Anderson', 'Kevin Wall', 'Beach Properties Thailand', 'Nee (Bldg. Mgr)', 'Nava Carlos', 'Markus Jabs', 'Powerhouse Ptry.', 'Alan Bolton Property Consultants', 'Dietmar Voigt', 'Nigel Heath', 'Rungnapa Kershaw', 'Alexey', 'Mr. William Stanwick', 'Golden Sand', 'Kanokwan Noparatanaraporn', 'Gerry Power', 'Wayne Morris', 'Yupaporn Sangpagdee', 'Andrew Kenrick', 'Georges Rothstein', 'Claas Kleine', 'Dao Ketthom', 'Gulya Lajos', 'Pranee Kamsawat', 'Mr. Martin Porter', 'Garry Wright', 'Mark Black', 'Oliver Nabarro', 'Mikhail Sorokin', 'Christopher Johnston', 'Daranee Chinsomboon', 'Natali Kuznetsoua', 'Mr. Tom or Su Courtney', 'Shiho Kawamura', 'Christine Wallace', 'Brian Brown', 'Richard Rhodes', 'Anchalee Pong-sot', 'Suwimon', 'Manasnan Jaikongsuwan (Mgr.)', 'Siwakarn Untaya', 'Ocean Marina', 'Thomas Hughes', 'Mr. Guy', 'Suwanna Maneelertrattana', 'Frank Waldecker', 'Michael Mueller', 'Dieter Sondun', 'Mr. Allen Bushnell', 'Allen Bushnell', 'Kanha Ketsuk', 'Thip', 'Alan Rahim', 'Bordin Phukoknoen', 'Siam Oriental Trading', 'Kevin Scott', 'Alan Lynch', 'Gino Zoccarato', 'Burt Schartz', 'Piti Techasiriwan', 'Poo', 'Hartmut Leppla', 'Chaikaseam', 'William Stewart Hamilton', 'John Pace', 'Marisa Puangprayong', 'Town & Country Property', 'Mukesh Thakkar', 'Mr. Daniel Boccalini', 'Mookbantom Kampeedee', 'Manouchehr Mohsenipour', 'Chen Chi Yu (Jimmy)', 'Arun Sapthai', 'Memo Moulaee', 'Siam Best Enterprises', 'Toni Kinnunen', 'Andrea Bocchi', 'Jason', 'Eric Peterson', 'William McCleary', 'John and Elena Pace', 'Jurgen Birkner', 'Dennis Starcevic', 'Dror Barouch', 'Anawin Gaolloni', 'Clayton Porter', 'Roland Stranneborn', 'Tom Yun', 'Terry Fraser', 'Giovanni Venturini', 'Vincenzo Pallone', 'Bryan Dodd', 'Asif Khan', 'Nattawut Charoenwong', 'Elena Kulikova', 'Brendan O Grandy', 'Mr. Tony Fallu', 'Stu Sutton', 'Mr. Bruno Pingel', 'Mr. Gulio Sappino', 'Albert St. Raymond', 'Wolf Freund', 'Russell Hancock', 'Natcha Tidkratok (Waan)', 'Guy', 'Bill Nicolson', 'Leonard Bucki', 'Tanawat Singpraek', 'Jeff Bukamier', 'Green Field Development Co., Ltd.', 'Dusadee Scarry', 'Frank Cusack', 'Sirikarn Rutwuttiwong', 'Peter Light', 'Bryant', 'Nigel Hackett', 'Philip Hoskison', 'Gary Baker', 'Shaun Burgess', 'Wanthanee Charoensiri', 'Luc De Roover', 'Steve Hannah & Nong Tongnak', 'Mark Johnson', 'Fredi Schaub', 'John McDryden', 'Ong Boulanatmeti', 'Roger Lewisham', 'Tirawat Dilokradtanatrakun', 'Kevin & Malee Scott', 'Chantima Woraprayoon', 'Colin De Jong', 'Andre Volgmann', 'Chanit Kulyut', 'Bob Garner', 'Pantharee Rujiratkittikul', 'Capt Steve Ponter', 'Pongsak Danurak', 'John Walden', 'Maximus', 'Panpaka Cannady', 'Darren Marshall', 'Nesrin Pesch', 'Aeed Kethom', 'Waranuch Sirovet Nukul', 'Marcus Nordt', 'Jean-Marc Seghezzi', 'Eduard Hegely', 'Kanokwan', 'Neoll Mitchell Smith', 'William F Cole', 'Clyde Best', 'Barry Johnstone', 'Jo Stetten', 'Andy Sitton', 'Jirut Rattanaprathipthong', 'Mr. Natnawat Teepakaporawat', 'Mr. Muenchai Panichpakdee', 'Veerai', 'Vit Chai', 'Rani Singh', 'William Clayton Simpson', 'Kom', 'Craig Rhodes', 'Maruwan Karnwiner', 'Evolution Capital', 'Jon Sarginson', 'Wolfgang Gruber', 'Pierre Casha', 'Douglas MacDonald', 'Daniel Boccalini', 'William Stanwick', 'Adrew Kenrick', 'Mark G.llian', 'Prani', 'Malee Scott, Kevin Scott', 'Natnawat Teepakaporawat', 'Muanchai Panichpakdee', 'PhilipHoskison', 'Rungnapha Kershaw', 'Sathitpon Bonsingchai', 'Nuttawut Charoenwong', 'Marisa Puangpayong, Butler Michael', 'Roland Sranneborn', 'The Paradise Residence', 'Mookbantom Kampeedee', 'Tony Fallu', 'Kaewinsuan', 'Jirut Rattanaprathipthong', 'MarisaPuangPayong Michael Butler', 'Natcha ThidgratokeW(aan)', 'Nigel hacket', 'Mohsenipour', 'Martin Porter', 'Markussabs', 'RobertT.Watkins', 'Tirawat', 'Sami Sarajarvi', 'Peter Handel-Mazzetti', 'Patcharee Pingel', 'Prathej', 'Fadi Eilas', 'Julia Leonova', 'Rattana (Komkrit', 'Julia /Tea', 'Jan Wahlgran', 'Robert Huttman', 'K. Nee', 'Khun Kanokwan', 'Robert Hultman', 'Michael Harrison', 'Louis Tailor', 'Bruno Pingel', 'Alexey Kalinichenko', 'Powerhouse', 'Wandee Group', 'Stefano DI Blasi', 'Ole Bqgelund Sorenser', 'Russell John Hancock', 'Tom Courtney', 'William Stanwick', 'Soontorn Munwongsri', 'Glulio Sappino', 'Peter Handel Mazzetti', 'Randy Hesterberg', 'Ptahia Weinstein', 'Robert T. Watkins', 'Thai Owner', 'Jason Young', 'Natcha Thidgratoke', 'agentcy', 'Khun No', 'Bill Grah', 'Ong', 'Kevin Scott', 'Peter Lewis', 'Paul Hunt', 'Guy Van Harten', 'Noel Mitchell-Smith', 'Sugitra Khongram', 'John Van Gemeren', 'Francois & Sandra Schuller', 'Thanakit Sitthmeteer', 'Peter wawowitz', 'Irina Akimova', 'Rungnapha Roypradit', 'Sonny Rasmussen', 'Christian Hoogstraate', 'Colin Horn', 'Tom Alexander', 'Modus Group', 'Sixty Six', 'Royal Hill Resort Co., Ltd.', 'Movenpick');
		    	
		$developers = array('The Urban Property','CCR Property','Nova Group','Iguana Co., Ltd.','Anana Agentcy Co., Ltd.','Bliss Thai Asset Company Limited','Ceen','Blue Sky Dev.','Sureeporn Surasa','Heights Holdings','Centara, Tulip Group','Tulip Group','Bellagio Development Co., Ltd.','Matrix Development Co., Ltd.','Shining Light','Plus Property Co., Ltd.','Duffy','Domum Holdings Co. Ltd.','Lara Home Property','McInnes Corp. Co., Ltd.','Clare Pattaya Property Co., Ltd.','Beach Mountain Condo','The Shining Star','LK Legend','Powerhouse Powerhouse Properties Co., Ltd.','Sriwong Boonkong (Fon)','Kat','Apex Development PCL','Royal Hill Resort','Raimon Land','Ocean Property','Surapee','Shanida','Pattaya City 2005 Co., Ltd.','Petch Pattaya Dev.','Major Dev.','McInnes Corp.','Stewart Mackay','Tale 66 Co., Ltd.','Powerhouse Ptry.','Petch Prpty. Dev.','MGT Real Estate','Koral Pattaya','Vanvisa Thamwattanacharoen','Nova','CBRE','The Paradise Residence','Vistas Dev.','Town & Country Property','Royal Oak Dev.','William Clayton Simpson','Deluca Corp., Ltd.','Troprical Dream Pattaya','Tudor Villas Co.','Coliers International','Zen Lifestyle Co.,Ltd','Sayan','Supanu Benchatikul','Tassaneewan Sampaongern','Khun No','Custom Homes','Mom\'s Ong','Horseshoe Point Property','Tom Dallyn','Lapttana Development Co, Ltd.','Ronnie Heggertveit','Matthaek','Mr. Peter Lewis','Jukarat Ruangratanakorn','Riverside park','VSPN Property','Windsor House Ltd.','Bang Saray Dev.','Paul Hunt','Suchat Chanchiawwichai','Suppaluck kruttharam','Albert St. Raymond','Bruno Pingel','Powerhouse','The Ocean Pearl','Suwanna Maneelertrattana','John Farr','MS Development','June Burnard','Sayan/Arnon Areesinpitak','Green Field Development Co., Ltd.','Lapattana Group','Ukarin Kerdkitsadanont','Suwanna Bunkoon','John O Donovan','CHM Development','Jeff Bukamier','Kevin Wall / Beach properties','Matrix','De Blue','Petch Dev.','Golden Beach Holdings');
		    	
		$em = $this->container->get('doctrine')->getEntityManager();
		
		$agency = $em->getRepository('PHRentalsMainBundle:ContactType')->findOneBy(array('name' => 'Agency'));
		$developer = $em->getRepository('PHRentalsMainBundle:ContactType')->findOneBy(array('name' => 'Developper'));
		$private_owner = $em->getRepository('PHRentalsMainBundle:ContactType')->findOneBy(array('name' => 'Private Owner'));
    	 
		foreach($em->getRepository('PHRentalsMainBundle:Contact')->findAll() as $contact) {
			
			$em->getRepository('PHRentalsMainBundle:ContactType')->findOneBy(array('name' => 'Agency'));
			
			if (in_array($contact->getName(),$agents)) {
				$contact->addContactType($agency);
			}
			if (in_array($contact->getName(),$developers)) {
				$contact->addContactType($developer);
			}
			if (in_array($contact->getName(),$private)) {
				$contact->addContactType($private_owner);
			}
			$em->persist($contact);
			$em->flush();
		}	
    } 
    
    
    /**
     Validate an email address.
     Provide email address (raw input)
     Returns true if the email address has the email
     address format and the domain exists.
     */
    private function validEmail($email)
    {
    	$isValid = true;
    	$atIndex = strrpos($email, "@");
    	if (is_bool($atIndex) && !$atIndex)
    	{
    		$isValid = false;
    	}
    	else
    	{
    		$domain = substr($email, $atIndex+1);
    		$local = substr($email, 0, $atIndex);
    		$localLen = strlen($local);
    		$domainLen = strlen($domain);
    		if ($localLen < 1 || $localLen > 64)
    		{
    			// local part length exceeded
    			$isValid = false;
    		}
    		else if ($domainLen < 1 || $domainLen > 255)
    		{
    			// domain part length exceeded
    			$isValid = false;
    		}
    		else if ($local[0] == '.' || $local[$localLen-1] == '.')
    		{
    			// local part starts or ends with '.'
    			$isValid = false;
    		}
    		else if (preg_match('/\\.\\./', $local))
    		{
    			// local part has two consecutive dots
    			$isValid = false;
    		}
    		else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
    		{
    			// character not valid in domain part
    			$isValid = false;
    		}
    		else if (preg_match('/\\.\\./', $domain))
    		{
    			// domain part has two consecutive dots
    			$isValid = false;
    		}
    		else if
    		(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
    				str_replace("\\\\","",$local)))
    		{
    			// character not valid in local part unless
    			// local part is quoted
    			if (!preg_match('/^"(\\\\"|[^"])+"$/',
    					str_replace("\\\\","",$local)))
    			{
    				$isValid = false;
    			}
    		}
    		if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
    		{
    		// domain not found in DNS
    			$isValid = false;
    		}
    		}
    		return $isValid;
    	}
    
    public function checkEmailAction() {
    		
    		$em = $this->container->get('doctrine')->getEntityManager();
    		
    		foreach($em->getRepository('PHRentalsMainBundle:Contact')->findAll() as $contact) {
    			
    			foreach($contact->getEmails() as $email) {
    				
    				if(!filter_var($email->getEmail(), FILTER_VALIDATE_EMAIL)){
    	    					print("<br>".$email->getEmail());
    				}
    				
   				
    				
    			}
    			
    		}
    		 
			exit;
    	}
		
	public function importAction() {
    	
    		$em = $this->container->get('doctrine')->getEntityManager();
    	
    		// get file
			
			$filename = "condo.txt";
    		 
    		$handle = fopen($filename,"r" );
    		 
    		$log = "";
			$log2 = "";
			$log3 = "";
    		$i = 1;
			$found = 0;
    		 
    		// skip first line
			
			/*
			$contents = fread ($handle,filesize ($filename));
			fclose ($handle); 
			$delimiter = "===";
			$splitcontents = explode($delimiter, $contents);
			
			foreach ( $splitcontents as $developer) {
			*/
			
			$equal_found = false;
								
    		if ($handle) {
				
	    		while ($line= fgets($handle))
	    		{
					
					// ---------------------------
					//     SEARCH FOR PROJECT
					// ---------------------------
					
					$project_found = "";
	    			//print(trim($line).'<br>');
	    			if (trim($line) != "") {
	    				
	    				//print($line.'<br>');
	    				//
	    				if (trim($line) == "===") {
							
							$line=fgets($handle);
	    					$line=fgets($handle);
	    					$project_name = trim($line);
							$project_name_save = $project_name;
	    					$project = $em->getRepository('PHRentalsMainBundle:Project')->findOneBy(array('name' => $project_name));
							
							if ($project) {
								$found++;
								$project_found = $project->getName();
							}
	    					//$log .= $i.'	'.$project_name.'	'.($project? 'OK' : '<font color=red>NOT FOUND</font>').'<br/>';
							
							if (!$project) {
								$project_name = str_replace('\'', '\'\'', $project_name);
$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
if (!$project && !$project_list) {
	$project_name = str_replace(' Pattaya', '', $project_name);
$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
}
if (!$project && !$project_list) {
	$project_name = str_replace(' Jomtien', '', $project_name);
$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
}
if (!$project && !$project_list) {
	$project_name = str_replace(' Condominiums', '', $project_name);
$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
}
if (!$project && !$project_list) {
	$project_name = str_replace(' Condominium', '', $project_name);
$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
}
if (!$project && !$project_list) {
	$project_name = str_replace(' Condo', '', $project_name);
$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
}
if (!$project && !$project_list) {
	$project_name = str_replace(' Resort', '', $project_name);
$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
}

								if ($project_list) {
									$found++;
									if(count($project_list)>1)  $log .= "<h1><font color=red>ALERT</font><br></h1>";
									foreach($project_list as $res) {
									//$log .= '<font color=green>FOUND '.$res['name'].'</font><br/>';
									$project = $res;
									$project_found = $res['name'];
									}
									
									$project = $em->getRepository('PHRentalsMainBundle:Project')->findOneBy(array('name' => $project['name']));
								}
							}
							
$log .= $i." / ".$project_name_save;

if (!$project_found) {
	$log .= "<font color=red>Project not found</font><br>";
	
	$project = new Project();
	$project->setName($project_name_save);
	$address = new Address();
	$project->setAddress($address);
	
} else {
	$log .= "<br>";
	
}

	    					$i++;
							
					// ---------------------------
					//     SEARCH FOR DATA
					// ---------------------------
							
							// developer
							$line=fgets($handle);
							
							if (trim($line) != "") {
								
								$dev = trim($line);
								
								$dev_name = str_replace(' Co., Ltd', '', $dev);
								$dev_name = str_replace(' Company', '', $dev_name);
								$dev_name = str_replace(' Ltd.', '', $dev_name);
								$dev_name = str_replace(' Developments', '', $dev_name);
								$dev_name = str_replace(' Development', '', $dev_name);
								$dev_name = str_replace(' Co.,', '', $dev_name);
								$dev_name = str_replace(' Thailand', '', $dev_name);
								
								//$contact = $em->getRepository('PHRentalsMainBundle:Contact')->findOneBy(array('name' => '%'.$dev_name.'%'));
								$contact_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Contact p WHERE p.name LIKE \'%'.$dev_name.'%\'')->getResult();
								if ($contact_list) {
									
								if(count($contact_list)>1)  $log .= "<h1><font color=red>ALERT CONTACT</font><br></h1>";
									
								foreach ($contact_list as $res) {
								$log .= "---------------	".$dev.' '.($res ? '<font color=green>'.$res['name'] : '<font color=red>not found').'</font><br>';
								$contact = $em->getRepository('PHRentalsMainBundle:Contact')->findOneBy(array('name' => $res['name']));
								if(!$project->getDeveloper()) {
									$project->setDeveloper($contact);
									}
								}
								} else {
									$log .= "---------------	".$dev.' <font color=red>Dev not found</font><br>';
								}
								
								$line=fgets($handle);
							}
							
							// address
							$address=trim(fgets($handle));
							
							$log .= "---------------	".$address.'<br>';
							
							if($project) {
								if(!$project->getAddress()->getText()) {
										$project->getAddress()->setText($address);
											$log3 .= 'UPDATE address SET address_text = "'.$address.'" WHERE id ="'.$project->getAddress()->getId().'";<br>';
										}
								else {
									$log .= "<font color=green>in database : </font>".$project->getAddress()->getText().'<br>';
								}
							}
							
	    				}
						
						
						// other
						$test = trim($line);
						
						if (strpos($test, "Request details or call") !== false) {
							$telephone = trim(substr($test,23));
							if ($telephone != "N/A" && $telephone != "") {
							$log .= "---------------	".'Telephone: '.$telephone.'<br>';

							if($project) {
								$project->setTelephone($telephone);
							}
							}
						}
							
							
							
						
						// Launched:
						if (strpos($test, "Launched:") !== false) {
							$launched = trim(substr($test,9));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Launched: '.$launched.'<br>';

							if($project) {
								$project->setLaunched($launched);
							}
							}
						}
							
						// Construction Starts:
						if (strpos($test, "Construction Starts:") !== false) {
							$launched = trim(substr($test,21));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Construction Starts: '.$launched.'<br>';

							if($project) {
								$project->setConstructionStarts($launched);
							}
							}
						}
						
						// Expected Completion:
							if (strpos($test, "Expected Completion:") !== false) {
							$launched = trim(substr($test,20));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Expected Completion: '.$launched.'<br>';

							if($project) {
								$project->setExpectedCompletion($launched);
								
								if($project->getCompletedOn() != "" && $project->getCompletedOn() != $launched) {
								$log2 .= $project->getName().';'.$project->getCompletedOn().';'.$launched.'<br>';
								}
								
								if(!$project->getCompletedOn() || $project->getCompletedOn() == "" || $project->getCompletedOn() == 'Finished') {
									$project->setCompletedOn($launched);
								} else {
									
									if ($project->getCompletedOn() != $launched )	 {
										$log .= "---------------	".'<font color=blue>Different completed On</font>: '.$project->getCompletedOn().'<br>';
										}
									
								}
								
							}
							}
						}
						
						//Build Duration:	
						if (strpos($test, "Build Duration:") !== false) {
							$launched = trim(substr($test,15));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Build Duration: '.$launched.'<br>';

							if($project) {
								$project->setBuildDuration($launched);
							}
							}
						}
						
						//Project Type:
						if (strpos($test, "Project Type:") !== false) {
							$launched = trim(substr($test,13));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Project Type: '.$launched.'<br>';

							if($project) {
								$project->setProjectType($launched);
							}
							}
						}
						
						//Total Buildings:
						if (strpos($test, "Total Buildings:") !== false) {
							$launched = trim(substr($test,16));
							if ($launched != "N/A" && $launched != "" && $launched > 0) {
							$log .= "---------------	".'Total Buildings: '.$launched.'<br>';

							if($project) {
								$project->setTotalBuildings($launched);
							}
							}
						}
						
						//Total Units:
						if (strpos($test, "Total Units:") !== false) {
							$launched = trim(substr($test,13));
							if ($launched != "N/A" && $launched != "" && $launched > 0) {
							$log .= "---------------	".'Total Units: '.$launched.'<br>';

							if($project) {
								$project->setTotalUnits($launched);
							}
							}
						}
						
						//Total Floors:
						if (strpos($test, "Total Floors:") !== false) {
							$launched = trim(substr($test,13));
							if ($launched != "N/A" && $launched != "" && $launched > 0) {
							$log .= "---------------	".'Total Floors: '.$launched.'<br>';

							if($project) {
								$project->setTotalFloors($launched);
							}
							}
						}
						
						//EIA Status:
						if (strpos($test, "EIA Status:") !== false) {
							$launched = trim(substr($test,11));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'EIA Status: '.$launched.'<br>';

							if($project) {
								$project->setEiaStatus($launched);
							}
							}
						}
						
						//Sales:
							if (strpos($test, "Sales:") !== false) {
							$launched = trim(substr($test,6));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Sales: '.$launched.'<br>';

							if($project) {
								$project->setSales($launched);
							}
							}
						}
							
						//Location / Directions:
							if (strpos($test, "Location / Directions:") !== false) {
								
							$location = trim(fgets($handle));
							if ($location != "") {
							$log .= "---------------	".'Location / Directions: '.$location.'<br>';

							if($project) {
								$project->setDirections($location);
							}
							}
						}	
							
						//Configuration:
							if (strpos($test, "Configuration:") !== false) {
								
							$configuration = trim(fgets($handle));
							if ($configuration != "") {
							$log .= "---------------	".'Configuration: '.$configuration.'<br>';

							if($project) {
								$project->setConfiguration($configuration);
							}
							}
						}
							
						//Composition:
							if (strpos($test, "Composition:") !== false) {
								
							$composition = trim(fgets($handle));
							if ($composition != "") {
							$log .= "---------------	".'Composition: '.$composition.'<br>';

							if($project) {
								$project->setComposition($composition);
							}
							}
						}
						
						//Sales Price Guide:
							if (strpos($test, "Sales Price Guide:") !== false) {
								
							$sales_price_guide = trim(fgets($handle));
							if ($sales_price_guide != "") {
							$log .= "---------------	".'Sales Price Guide: '.$sales_price_guide.'<br>';

							if($project) {
								$project->setSalesPriceGuide($sales_price_guide);
							}
							}
						}
							
						//Amenities:
							if (strpos($test, "Amenities:") !== false) {
							$amenities = "";
							$amenities_line = trim(fgets($handle));
							while ($amenities_line != "") {
								$amenities .= $amenities_line. "\n";
								$amenities_line = trim(fgets($handle));
							}

							if ($amenities != "") {
							$log .= "---------------	".'Amenities: '.$amenities.'<br>';

							if($project) {
								$project->setAmenities($amenities);
								
								// address tags
								
								$amenities = strtolower($amenities);
								
								if (strpos($amenities, "pool") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'shared swimming pool')));
								}
                                
                                if (strpos($amenities, "internet") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'internet')));
								}
                                
                                if (strpos($amenities, "surface parking") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'surface parking')));
								} 
                                elseif (strpos($amenities, "covered parking") !== false || strpos($amenities, "underground parking") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'covered parking')));
								} elseif (strpos($amenities, "parking") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'surface parking')));
								}
                                
                                if (strpos($amenities, "restaurant") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'restaurant')));
								}
                                
                                if (strpos($amenities, "gym") !== false || strpos($amenities, "fitness") !== false || strpos($amenities, "exercise room") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'sport facilities / gym')));
								}
                                
                                if (strpos($amenities, "security") !== false || strpos($amenities, "cctv") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'security')));
								}
                                
                                if (strpos($amenities, "garden") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'garden')));
								}
                                
                                if (strpos($amenities, "laundry") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'laundry')));
								}
                                
                                if (strpos($amenities, "convenience store") !== false || strpos($amenities, "mini-mart") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'mini-mart')));
								}
                                
                                if (strpos($amenities, "spa") !== false || strpos($amenities, "massage") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'spa/massage')));
								}
                                
                                if (strpos($amenities, "sauna") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'sauna')));
								}
                                
                                if (strpos($amenities, "jacuzzi") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'jacuzzi')));
								}
                                
                                if (strpos($amenities, "private beach") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'private beach access')));
								}
                                
                                if (strpos($amenities, "tennis") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'tennis court')));
								}
                                
                                if (strpos($amenities, "cafe") !== false || strpos($amenities, "coffee shop") !== false || strpos($amenities, "bar") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'cafe/coffee shop/bar')));
								}
                                
                                if (strpos($amenities, "reception") !== false || strpos($amenities, "concierge") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'reception/concierge service')));
								}
                                
                                if (strpos($amenities, "business centre") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'business centre')));
								}
                                
                                if (strpos($amenities, "library") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'library')));
								}
								
								
											// end address tags
														
							}
							}
						}
						
						
						//Security:
							if (strpos($test, "Security:") !== false) {
								
							$security = trim(fgets($handle));
							if ($security != "") {
							$log .= "---------------	".'Security: '.$security.'<br>';

							if($project) {
								$project->setSecurity($security);
								if (strpos($security, "cctv") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'security with CCTV')));
								} else {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'security')));	
								}
							}
							}
						}
							
						//Description:
							if (strpos($test, "Description:") !== false) {
							$description = "";
							while (($description_line = trim(fgets($handle))) != "===") {
								$description .= $description_line. "\n";
							}

							if ($description != "") {
							$log .= "---------------	".'Description: '.$description.'<br>';

							if($project) {
								$project->setDescriptiontext($description);
							}
							}
							
							//$em->persist($project);
							//$em->flush();
							
						}

						
	    			} 
	    		}
	    		if (!feof($handle)) {
	    			echo "Error: unexpected fgets() fail\n";
	    		}
	    		fclose($handle);
	    	}
    		
			//fclose($handle);
			
    		//$em->flush();
    		 
    		print($log3);
			//print($found."/".$i);
			//print($log2);
    		exit;
    		 
    		$message = 'Units crées avec succès.';
    		 
    		return $this->container->get('templating')->renderResponse('PHRentalsMainBundle:Default:import.html.twig',
    				array('message' => $message)
    		);
    		
    		
    		
    	}
		
    	
    public function import22Action() {
    	
    		$em = $this->container->get('doctrine')->getEntityManager();
    	
    		// get file
			
			$filename = "condo3.txt";
    		 
    		$handle = fopen($filename,"r" );
    		 
    		$log = "";
			$log2 = "";
			$log3 = "";
    		$i = 1;
			$found = 0;
    		 
    		// skip first line
			
			/*
			$contents = fread ($handle,filesize ($filename));
			fclose ($handle); 
			$delimiter = "===";
			$splitcontents = explode($delimiter, $contents);
			
			foreach ( $splitcontents as $developer) {
			*/
					
    		if ($handle) {
				
	    		while ($line= fgets($handle))
	    		{
					
					// ---------------------------
					//     SEARCH FOR PROJECT
					// ---------------------------
					
					$project_found = "";
	    			//print(trim($line).'<br>');
	    			if (trim($line) != "") {
	    				
	    				//print($line.'<br>');
	    				//
	    				if (trim($line) == "===") {
							
							if (isset($project)) {
							//$em->persist($project);
							//$em->flush();
							}
							
							$line=fgets($handle);
	    					$line=trim(fgets($handle));
	    					$project_name = $line;
							
							$project_name = str_replace('*', '', $project_name);
							
							switch (strlen($line)-strlen($project_name)) {
								case 0:
									$district = "";
									break;
								case 1:
									$district = "Any";
									break;
								case 2:
									$district = "Bangkok";
									break;
								case 3:
									$district = "Jomtien";
									break;
								case 4:
									$district = "Na Jomtien";
									break;
								case 5:
									$district = "Pratumnak";
									break;
								case 6:
									$district = "Wong Amat";
									break;
								case 7:
									$district = "Central Pattaya";
									break;
							}
							
							
							$project_name = trim($project_name);
							$project_name_save = $project_name;
	    					$project = $em->getRepository('PHRentalsMainBundle:Project')->findOneBy(array('name' => $project_name));
							
							if ($project) {
								$found++;
								$project_found = $project->getName();
							}
	    					//$log .= $i.'	'.$project_name.'	'.($project? 'OK' : '<font color=red>NOT FOUND</font>').'<br/>';
							
							if (!$project) {
								$project_name = str_replace('\'', '\'\'', $project_name);
								$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
								if (!$project && !$project_list) {
									$project_name = str_replace(' Pattaya', '', $project_name);
								$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
								}
								if (!$project && !$project_list) {
									$project_name = str_replace(' Jomtien', '', $project_name);
								$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
								}
								if (!$project && !$project_list) {
									$project_name = str_replace(' Condominiums', '', $project_name);
								$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
								}
								if (!$project && !$project_list) {
									$project_name = str_replace(' Condominium', '', $project_name);
								$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
								}
								if (!$project && !$project_list) {
									$project_name = str_replace(' Condo', '', $project_name);
								$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
								}
								if (!$project && !$project_list) {
									$project_name = str_replace(' Resort', '', $project_name);
								$project_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Project p WHERE p.name LIKE \'%'.$project_name.'%\'')->getResult();
								}

								if ($project_list) {
									$found++;
									if(count($project_list)>1)  $log .= "<h1><font color=red>ALERT</font><br></h1>";
									foreach($project_list as $res) {
									//$log .= '<font color=green>FOUND '.$res['name'].'</font><br/>';
									$project = $res;
									$project_found = $res['name'];
									}
									
									$project = $em->getRepository('PHRentalsMainBundle:Project')->findOneBy(array('name' => $project['name']));
								}
}
							
$log .= $i." / ".$project_name_save;

if (!$project_found) {
	$log .= "<font color=red>Project not found</font><br>";
	
	$project = new Project();
	$project->setName($project_name_save);
	$address = new Address();
	$project->setAddress($address);
	
	if ($district != "") {
		$district_entity = $em->getRepository('PHRentalsMainBundle:District')->findOneBy(array('name' => $district));
		$project->getAddress()->setDistrict($district_entity);
		$log .= "<font color=blue>NEW DISTRICT</font> : ".$district_entity."<br>";
	}
	
} else {
	$log .= "<br>";
	if (!$project->getAddress()->getDistrict()) {
		$district_entity = $em->getRepository('PHRentalsMainBundle:District')->findOneBy(array('name' => $district));
		$project->getAddress()->setDistrict($district_entity);
		$log .= "<font color=blue>NEW DISTRICT</font> : ".$district_entity."<br>";
	}
}

$log .= "DISTRICT : ".$district."<br>";



//$em->persist($project);
//$em->flush();

	    					$i++;
						}
							
							
					// ---------------------------
					//     SEARCH FOR DATA
					// ---------------------------
							
							// developer
							//$line=fgets($handle);
							
							if (strpos(trim($line), "Property Developer:") !== false) {
								
								$dev = trim(substr(trim($line),19));
								
								$dev_name = str_replace(' Co., Ltd', '', $dev);
								$dev_name = str_replace(' Company', '', $dev_name);
								$dev_name = str_replace(' Ltd.', '', $dev_name);
								$dev_name = str_replace(' Developments', '', $dev_name);
								$dev_name = str_replace(' Development', '', $dev_name);
								$dev_name = str_replace(' Co.,', '', $dev_name);
								$dev_name = str_replace(' Thailand', '', $dev_name);
								
								//$contact = $em->getRepository('PHRentalsMainBundle:Contact')->findOneBy(array('name' => '%'.$dev_name.'%'));
								$contact_list = $em->createQuery('SELECT p.name as name FROM PHRentalsMainBundle:Contact p WHERE p.name LIKE \'%'.$dev_name.'%\'')->getResult();
								if ($contact_list) {
									
								if(count($contact_list)>1)  $log .= "<h1><font color=red>ALERT CONTACT</font><br></h1>";
									
								foreach ($contact_list as $res) {
								$log .= "---------------	".$dev.' '.($res ? '<font color=green>'.$res['name'] : '<font color=red>not found').'</font><br>';
								$contact = $em->getRepository('PHRentalsMainBundle:Contact')->findOneBy(array('name' => $res['name']));
								if(!$project->getDeveloper()) {
									$project->setDeveloper($contact);
									}
								}
								} else {
									$log .= "---------------	".$dev.' <font color=red>Dev not found</font><br>';
								}
								
							}
							
							
							
							// address
							
							if (strpos(trim($line), "Address:") !== false) {
							
							$address = trim(substr(trim($line),8));
							
							$log .= "---------------	".$address.'<br>';
							
							if($project) {
								if(!$project->getAddress()->getText()) {
										$project->getAddress()->setText($address);
										$log3 .= 'UPDATE address SET address_text = "'.$address.'" WHERE id ="'.$project->getAddress()->getId().'";<br>';
										}
								else {
									$log .= "<font color=green>in database : </font>".$project->getAddress()->getText().'<br>';
									$log3 .= 'UPDATE address SET address_text = "'.$address.'" WHERE id ="'.$project->getAddress()->getId().'";<br>';
								}
							}
							
	    				}
						
						
						// other
						//$test = trim($line);
						
						
						// Year of completion:
							if (strpos(trim($line), "Year of completion:") !== false) {
							$launched = trim(substr(trim($line),20));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Year of completion: '.$launched.'<br>';

							if($project) {
								$project->setExpectedCompletion($launched);
								
								if($project->getCompletedOn() != "" && $project->getCompletedOn() != $launched) {
								$log2 .= $project->getName().';'.$project->getCompletedOn().';'.$launched.'<br>';
								}
								
								if(!$project->getCompletedOn() || $project->getCompletedOn() == "" || $project->getCompletedOn() == 'Finished') {
									$project->setCompletedOn($launched);
								} else {
									
									if ($project->getCompletedOn() != $launched )	 {
										$log .= "---------------	".'<font color=blue>Different completed On</font>: '.$project->getCompletedOn().'<br>';
										}
									
								}
								
							}
							}
						}
						
						
						
						// website
						
						if (strpos(trim($line), "http://") !== false) {
							$website = trim($line);
							if ($website != "N/A" && $website != "") {
							$log .= "---------------	".'Web: '.$website.'<br>';

							if(!$project->getWebsite()) {
								//$project->setWebsite($website);
							}
							}
						}
						
/*
Sinking fund:
Maintenance fee:
Transfer is
	*/					if (strpos(trim($line), "Distance to the beach") !== false) {
							$distance = trim(str_replace("Distance to the beach", "",$line));
							$distance = trim(str_replace("m.", "",$distance));
							if ($distance != "N/A" && $distance != "") {
							$log .= "---------------	".'Distance: '.$distance.'<br>';

							if(!$project->getAddress()->getDistanceToBeach()) {
								$project->getAddress()->setDistanceToBeach($distance);
							}
							}
						}
							
						if (strpos(trim($line), "Sinking fund:") !== false) {
							$fund = trim(str_replace("Sinking fund:", "",$line));
							if ($fund != "N/A" && $fund != "") {
							$log .= "---------------	".'fund: '.$fund.'<br>';

							if(!$project->getSinkingFund()) {
								$project->setSinkingFund($fund);
							}
							}
						}
						
						if (strpos(trim($line), "Maintenance fee:") !== false) {
							$fee = trim(str_replace("Maintenance fee:", "",$line));
							if ($fee != "N/A" && $fee != "") {
							$log .= "---------------	".'fee: '.$fee.'<br>';

							if(!$project->getMaintenanceFee()) {
								$project->setMaintenanceFee($fee);
							}
							}
						}
						
						
						if (strpos(trim($line), "Furnishing") !== false) {
							$furnishing = trim(str_replace("Furnishing", "",$line));
							if ($furnishing != "N/A" && $furnishing != "") {
							$log .= "---------------	".'Furnishing: '.$furnishing.'<br>';

							if(!$project->getFurnished()) {
								$project->setFurnished($furnishing);
							}
							}
						}
						
						
						
						if (strpos(trim($line), "Booking deposit") !== false) {
							$deposit = trim(str_replace("Booking deposit", "",$line));
							if ($deposit != "N/A" && $deposit != "") {
							$log .= "---------------	".'Booking deposit: '.$deposit.'<br>';

							if(!$project->getDeposit()) {
								$project->setDeposit($deposit);
							}
							}
						}
						
						 
						if (strpos(trim($line), "Payment by installments") !== false) {
							$installments = trim(str_replace("Payment by installments", "",$line));
							if ($installments != "N/A" && $installments != "") {
							$log .= "---------------	".'Payment by installments: '.$installments.'<br>';

							if(!$project->getInstallments()) {
								$project->setInstallments($installments);
							}
							}
						}
						
						// Tel
						if (strpos(trim($line), "Request details or call") !== false) {
							$telephone = trim(substr(trim($line),23));
							if ($telephone != "N/A" && $telephone != "") {
							$log .= "---------------	".'Telephone: '.$telephone.'<br>';

							if($project) {
								$project->setTelephone($telephone);
							}
							}
						}
							
							
							
						
						// Launched:
						if (strpos(trim($line), "Launched:") !== false) {
							$launched = trim(substr(trim($line),9));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Launched: '.$launched.'<br>';

							if($project) {
								$project->setLaunched($launched);
							}
							}
						}
							
						// Construction Starts:
						if (strpos(trim($line), "Construction Starts:") !== false) {
							$launched = trim(substr(trim($line),21));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Construction Starts: '.$launched.'<br>';

							if($project) {
								$project->setConstructionStarts($launched);
							}
							}
						}
						
						// Expected Completion:
							if (strpos(trim($line), "Expected Completion:") !== false) {
							$launched = trim(substr(trim($line),20));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Expected Completion: '.$launched.'<br>';

							if($project) {
								$project->setExpectedCompletion($launched);
								
								if($project->getCompletedOn() != "" && $project->getCompletedOn() != $launched) {
								$log2 .= $project->getName().';'.$project->getCompletedOn().';'.$launched.'<br>';
								}
								
								if(!$project->getCompletedOn() || $project->getCompletedOn() == "" || $project->getCompletedOn() == 'Finished') {
									$project->setCompletedOn($launched);
								} else {
									
									if ($project->getCompletedOn() != $launched )	 {
										$log .= "---------------	".'<font color=blue>Different completed On</font>: '.$project->getCompletedOn().'<br>';
										}
									
								}
								
							}
							}
						}
						
						//Build Duration:	
						if (strpos(trim($line), "Build Duration:") !== false) {
							$launched = trim(substr(trim($line),15));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Build Duration: '.$launched.'<br>';

							if($project) {
								$project->setBuildDuration($launched);
							}
							}
						}
						
						//Project Type:
						if (strpos(trim($line), "Project Type:") !== false) {
							$launched = trim(substr(trim($line),13));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Project Type: '.$launched.'<br>';

							if($project) {
								$project->setProjectType($launched);
							}
							}
						}
						
						//Total Buildings:
						if (strpos(trim($line), "Total Buildings:") !== false) {
							$launched = trim(substr(trim($line),16));
							if ($launched != "N/A" && $launched != "" && $launched > 0) {
							$log .= "---------------	".'Total Buildings: '.$launched.'<br>';

							if($project) {
								$project->setTotalBuildings($launched);
							}
							}
						}
						
						//Total Units:
						if (strpos(trim($line), "Total Units:") !== false) {
							$launched = trim(substr(trim($line),13));
							if ($launched != "N/A" && $launched != "" && $launched > 0) {
							$log .= "---------------	".'Total Units: '.$launched.'<br>';

							if($project) {
								$project->setTotalUnits($launched);
							}
							}
						}
						
						//Total Floors:
						if (strpos(trim($line), "Total Floors:") !== false) {
							$launched = trim(substr(trim($line),13));
							if ($launched != "N/A" && $launched != "" && $launched > 0) {
							$log .= "---------------	".'Total Floors: '.$launched.'<br>';

							if($project) {
								$project->setTotalFloors($launched);
							}
							}
						}
						
						//EIA Status:
						if (strpos(trim($line), "EIA Status:") !== false) {
							$launched = trim(substr(trim($line),11));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'EIA Status: '.$launched.'<br>';

							if($project) {
								$project->setEiaStatus($launched);
							}
							}
						}
						
						//Sales:
							if (strpos(trim($line), "Sales:") !== false) {
							$launched = trim(substr(trim($line),6));
							if ($launched != "N/A" && $launched != "") {
							$log .= "---------------	".'Sales: '.$launched.'<br>';

							if($project) {
								$project->setSales($launched);
							}
							}
						}
							
						//Location / Directions:
							if (strpos(trim($line), "Location / Directions:") !== false) {
								
							$location = trim(fgets($handle));
							if ($location != "") {
							$log .= "---------------	".'Location / Directions: '.$location.'<br>';

							if($project) {
								$project->setDirections($location);
							}
							}
						}	
							
						//Configuration:
							if (strpos(trim($line), "Configuration:") !== false) {
								
							$configuration = trim(fgets($handle));
							if ($configuration != "") {
							$log .= "---------------	".'Configuration: '.$configuration.'<br>';

							if($project) {
								$project->setConfiguration($configuration);
							}
							}
						}
							
						//Composition:
							if (strpos(trim($line), "Composition:") !== false) {
								
							$composition = trim(fgets($handle));
							if ($composition != "") {
							$log .= "---------------	".'Composition: '.$composition.'<br>';

							if($project) {
								$project->setComposition($composition);
							}
							}
						}
						
						//Sales Price Guide:
							if (strpos(trim($line), "Sales Price Guide:") !== false) {
								
							$sales_price_guide = trim(fgets($handle));
							if ($sales_price_guide != "") {
							$log .= "---------------	".'Sales Price Guide: '.$sales_price_guide.'<br>';

							if($project) {
								$project->setSalesPriceGuide($sales_price_guide);
							}
							}
						}
							
						//Amenities:
							if (strpos(trim($line), "Amenities:") !== false) {
							$amenities = "";
							$amenities_line = trim(fgets($handle));
							while ($amenities_line != "") {
								$amenities .= $amenities_line. "\n";
								$amenities_line = trim(fgets($handle));
							}

							if ($amenities != "") {
							$log .= "---------------	".'Amenities: '.$amenities.'<br>';

							if($project) {
								$project->setAmenities($amenities);
								
								// address tags
								
								$amenities = strtolower($amenities);
								
								if (strpos($amenities, "pool") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'shared swimming pool')));
								}
                                
                                if (strpos($amenities, "internet") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'internet')));
								}
                                
                                if (strpos($amenities, "surface parking") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'surface parking')));
								} 
                                elseif (strpos($amenities, "covered parking") !== false || strpos($amenities, "underground parking") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'covered parking')));
								} elseif (strpos($amenities, "parking") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'surface parking')));
								}
                                
                                if (strpos($amenities, "restaurant") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'restaurant')));
								}
                                
                                if (strpos($amenities, "gym") !== false || strpos($amenities, "fitness") !== false || strpos($amenities, "exercise room") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'sport facilities / gym')));
								}
                                
                                if (strpos($amenities, "security") !== false || strpos($amenities, "cctv") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'security')));
								}
                                
                                if (strpos($amenities, "garden") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'garden')));
								}
                                
                                if (strpos($amenities, "laundry") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'laundry')));
								}
                                
                                if (strpos($amenities, "convenience store") !== false || strpos($amenities, "mini-mart") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'mini-mart')));
								}
                                
                                if (strpos($amenities, "spa") !== false || strpos($amenities, "massage") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'spa/massage')));
								}
                                
                                if (strpos($amenities, "sauna") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'sauna')));
								}
                                
                                if (strpos($amenities, "jacuzzi") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'jacuzzi')));
								}
                                
                                if (strpos($amenities, "private beach") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'private beach access')));
								}
                                
                                if (strpos($amenities, "tennis") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'tennis court')));
								}
                                
                                if (strpos($amenities, "cafe") !== false || strpos($amenities, "coffee shop") !== false || strpos($amenities, "bar") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'cafe/coffee shop/bar')));
								}
                                
                                if (strpos($amenities, "reception") !== false || strpos($amenities, "concierge") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'reception/concierge service')));
								}
                                
                                if (strpos($amenities, "business centre") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'business centre')));
								}
                                
                                if (strpos($amenities, "library") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'library')));
								}
								
								
											// end address tags
														
							}
							}
						}
						
						
						//Security:
							if (strpos(trim($line), "Security:") !== false) {
								
							$security = trim(fgets($handle));
							if ($security != "") {
							$log .= "---------------	".'Security: '.$security.'<br>';

							if($project) {
								$project->setSecurity($security);
								if (strpos($security, "cctv") !== false) {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'security with CCTV')));
								} else {
						$project->getAddress()->addTag($em->getRepository('PHRentalsMainBundle:AddressTag')->findOneBy(array('name' => 'security')));	
								}
							}
							}
						}
							
						//Description:
							if (strpos(trim($line), "Description:") !== false) {
							$description = "";
							while (($description_line = trim(fgets($handle))) != "") {
								$description .= $description_line. "\n";
							}

							if ($description != "") {
							$log .= "---------------	".'Description: '.$description.'<br>';

							if($project) {
								$project->setDescriptiontext($description);
							}
							}
					
							
						}
						
						

						
	    			} 
	    		}
	    		if (!feof($handle)) {
	    			echo "Error: unexpected fgets() fail\n";
	    		}
	    		fclose($handle);
	    	}
    		
			//fclose($handle);
			
    		//$em->flush();
    		 
    		print($log3);
			//print($found."/".$i);
			//print($log2);
    		exit;
    		 
    		$message = 'Units crées avec succès.';
    		 
    		return $this->container->get('templating')->renderResponse('PHRentalsMainBundle:Default:import.html.twig',
    				array('message' => $message)
    		);
    		
    		
    		
    	}
		
		
    public function importPPBAction() {
    	
    		$em = $this->container->get('doctrine')->getEntityManager();
    	
    		// get file
    		 
    		$handle = fopen("dev.txt","r" );
    		 
    		$log = "";
    		$i = 1;
			$found = 0;
    		 
    		// skip first line

    		//$line=fgets($handle);
    	
			while ($line=fgets($handle))
			{
				$data = array();
	
				list($data['Developer D-Ref'], $data['ppb id'], $data['Project/Building Name'], $data['Company Name'], $data['commission remarks'], $data['Foreign Com. %'], $data['Thai /Company Com. %'], $data['Developer Address'], $data['Head Office #'], $data['Office #'], $data['Fax #'], $data['Mobile #'], $data['Email']) = explode(";", $line);
				
				$data = array_map('trim', $data);
				
				echo $i. " : ". $data['Project/Building Name'];
				
				$project = $em->getRepository('PHRentalsMainBundle:Project')->find($data['ppb id']);
				
				if (!$project) {
					echo " <font color=red>NOT</font>"."<br/>";
				} else {
					echo "<br/>";
					
				$address = $project->getAddress();
				
				$developer = $em->getRepository('PHRentalsMainBundle:Contact')->findOneBy(array('name' => $data['Company Name']));
				
				if ($developer) {
					echo 'DEV :'.$developer->getName()."<br>";
				} else {
					echo '<font color=orange>DEV NOT FOUND :'.$data['Company Name']."</font><br>";
					$developer = new Contact;
					$user = $this->container->get('security.context')->getToken()->getUser();
					$developer->setValidatedByUser($user);
					$developer->setName($data['Company Name']);
					$developer->setCreatedByUser($user);
				}
				
					$project->setDeveloper($developer);
				
					$developer_type = $em->getRepository('PHRentalsMainBundle:ContactType')->findOneBy(array('name' => 'Developer'));

					if(!$developer->hasType($developer_type)) {
						$developer->addContactType($developer_type);
					}
					
					$developer->setOwnerRef($data['Developer D-Ref']);
				
					
					$dev_type = $em->getRepository('PHRentalsMainBundle:ContactDevType')->findOneBy(array('name' => 'Condominimums'));
					if(!$developer->hasDevType($dev_type)) {
						$developer->addDevType($dev_type);
					}
					
					if($data['Email']) {
						$email = new ContactEmail;
						$email->setEmail($data['Email']);
						$developer->addEmail($email);
					}
					 
					if($data['Head Office #']) {
						$tel = new ContactTel;
						$tel->setTel($data['Head Office #']);
						$tel->setNote('Head Office');
						$developer->addTel($tel);
					}
					if($data['Office #']) {
						$tel = new ContactTel;
						$tel->setTel($data['Office #']);
						$tel->setNote('Office');
						$developer->addTel($tel);
					}
					if($data['Fax #']) {
						$tel = new ContactTel;
						$tel->setTel($data['Fax #']);
						$tel->setNote('Fax');
						$developer->addTel($tel);
					}
					if($data['Mobile #']) {
						$tel = new ContactTel;
						$tel->setTel($data['Mobile #']);
						$tel->setNote('Mobile');
						$developer->addTel($tel);
					}
					
					if($data['Developer Address'] && !$developer->getAddress()) {
						$developer->setAddress($data['Developer Address']);
					}
					
						$notes = array();
						if($developer->getNotes()) { $notes[] = $developer->getNotes(); }
						if($data['commission remarks']) $notes[] = $data['commission remarks'];
						if($data['Foreign Com. %']) $notes[] = "Foreign Com.:".$data['Foreign Com. %']." %";
						if($data['Thai /Company Com. %']) $notes[] = "Thai /Company Com.: ".$data['Thai /Company Com. %']." %";
						
						if($notes) $notes = implode("\n", $notes);
						$developer->setNotes($notes);
					
				
				$em->persist($developer);
				$em->persist($project);
				$em->persist($address);
				$em->flush();
				
				
				}
				$i++;
		}
		exit;
    }
    
    
}
