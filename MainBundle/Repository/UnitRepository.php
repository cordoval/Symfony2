<?php

namespace PHRentals\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;

/**
 * UnitRepository
 *
 */
class UnitRepository extends EntityRepository
{
	
	public function findNextRef()
	{
		$ref = $this->getEntityManager()
		->createQuery('SELECT MAX(p.pRef) FROM PHRentalsMainBundle:Unit p')
		->getSingleScalarResult();
		//$ref= $result[0]->;
		$ref++;
	
		return $ref;
	}
	
	public function createSlug($unit)
	{
		
		$slug = $unit->getWebTitle().'-';
		
		if($unit->getProject()) {
			if(!$unit->getProject()->getAddress()->getDistrict()) {
				return false;
			}
			$slug .= $unit->getProject()->getAddress()->getDistrict()->getName();
		} elseif ($unit->getAddress()){
			if(!$unit->getAddress()->getDistrict()) {
				return false;
			}
			$slug .= $unit->getAddress()->getDistrict()->getName();
		}
		
		$slug .= '-'.$unit->getPRef();
		
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", "-", $clean);
		
		//$slug = mysql_real_escape_string($clean);
	
		$slug = $clean;
		
		return $slug;
	}
	
	public function findAvailableUnits($data)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$query = $qb->select('u')
				->from('PHRentalsMainBundle:Unit','u')
				->leftJoin('u.address', 'a')
				->where('u.unitClass = :unitClass AND u.unitSize = :unitSize AND a.district = :district')
				->setParameter('unitClass', $data['unitClass'])
				->setParameter('unitSize', $data['unitSize'])
				->setParameter('district', $data['district']);
		
		if ($data['size'] > 0) {
			$query->andWhere('u.livingArea >= \''.$data['size'].'\'');
		}
		if ($data['bedrooms'] > 0) {
			$query->andWhere('u.bedrooms = \''.$data['bedrooms'].'\'');
		}
		if ($data['bathrooms'] > 0) {
			$query->andWhere('u.bathrooms = \''.$data['bathrooms'].'\'');
		}
		if ($data['sleeps'] > 0) {
			$query->andWhere('u.sleeps = \''.$data['sleeps'].'\'');
		}
		if ($data['distanceToBeach']) {
			$query->andWhere('a.distanceToBeach = \''.$data['distanceToBeach'].'\'');
		}
		if ($data['price']) {
			$query->andWhere('u.baseRate <= \''.$data['price'].'\'');
		}
		
		
		
		
		$units = $qb->getQuery()->getResult();
	
		//$reservation->getDateFrom()->format('Y-m-d')

	
		return $units;
	}
	
	public function findReservations($id)
	{
		$resas = $this->getEntityManager()
		->createQuery('SELECT * FROM PHRentalsMainBundle:Reservation p WHERE u.unit_id = ?1')
		->setParameter(1, $id)
		->getResult();
		
		return $resas;
	}
	
	public function findReservationsBetweenDates($id, $from, $to)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$query = $qb->select('u')
		->from('PHRentalsMainBundle:Reservation', 'u')
		->where('u.unit = :unit AND ((u.dateFrom >= :from AND u.dateFrom <= :to) OR (u.dateTo > :from AND u.dateTo <= :to) OR (u.dateFrom < :from AND u.dateTo >= :to))')
		->setParameter('unit', $id)
		->setParameter('from', $from)
		->setParameter('to', $to);
		
		//$reservation->getDateFrom()->format('Y-m-d')

		$resas = $qb->getQuery()->getResult();
		
		return $resas;
	}
	
	public function hasTag($tag)
	{
	
		return true;
	}
	
	public function findUnits($data)
	{
		global $search_string;
		
		$filter = array();
		
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$query = $qb->select('u')
		->from('PHRentalsMainBundle:Unit','u')
		->innerJoin('u.owner', 'o')
		->innerJoin('u.contracts', 'uc')
		->innerJoin('uc.contract', 'ucc')
		->leftJoin('u.project', 'p')
		;
	
		// Reference
		if($data['reference']) {
			$ref_list = explode(",", $data['reference']);
			$ref_list = array_map('trim', $ref_list);
			
			if ($data['refentity'] == 'O') {
				$filter[] = "O-Ref: ".implode("','", $ref_list);
				$query->andWhere('o.ownerRef IN (\''.implode("','", $ref_list).'\')');
			}
			if ($data['refentity'] == 'K') {
				$filter[] = "K-Ref: ".implode("','", $ref_list);
				//$query->andWhere('ucc.kRef IN (\''.implode("','", $ref_list).'\')');
				$query->andWhere('(ucc.kRef LIKE \'%'.implode("%' OR ucc.kRef LIKE '%", $ref_list).'%\')');
			}
			if ($data['refentity'] == 'P') {
				$filter[] = "P-Ref: ".implode("','", $ref_list);
				$query->andWhere('(u.pRef LIKE \'%'.implode("%' OR u.pRef LIKE '%", $ref_list).'%\')');
				
			}
		}
		
		// Keywords
		if ($data['keyword'] != "") {
			$filter[] = "Free Search: ".$data['keyword'];
			$query
			->andWhere('u.num LIKE \'%'.str_replace('\'', '\'\'', $data['keyword']).'%\' OR p.name LIKE \'%'.str_replace('\'', '\'\'', $data['keyword']).'%\' OR u.webTitle LIKE \'%'.str_replace('\'', '\'\'', $data['keyword']).'%\'');
		}
		
		//Active
		if(isset($data['active']) && !isset($data['inactive'])) {
			$filter[] = "Active";
				$query->andWhere('u.active = 1');
		} elseif(isset($data['inactive']) && !isset($data['active'])) {
			$query->andWhere('u.active = 0');
			$filter[] = "Inactive";
		}
		
		//unitClass
		if(isset($data['unitClass'])) {
			$query->leftJoin('u.class', 'ucl');
			$query->andWhere('ucl.name = \''.$data['unitClass'].'\'');
			$filter[] = "Class: ".$data['unitClass'];
		}
		
		//bedrooms
		if(isset($data['studio'])) {
				$query->leftJoin('u.unitType', 'ut');
				
				if(!isset($data['bedrooms'])) {
				$query->andWhere('ut.name = \'studio\'');
				$filter[] = "Type: Studio";
				}
			}
		if(isset($data['bedrooms'])) {
			$query_bedrooms = array();
			foreach($data['bedrooms'] as $bedroom) {
				$filter[] = "Bedrooms: ".$bedroom;
				if(count($data['bedrooms'])>1) {
					if($bedroom=='5+') {
						$query_bedrooms[] = 'u.bedrooms > 4';
					} else {
						$query_bedrooms[] = 'u.bedrooms = '.$bedroom;
					}
				} else {
					if($bedroom=='5+') {
						$query_bedrooms[] = 'u.bedrooms > 4';
					} else {
						$query_bedrooms[] = 'u.bedrooms = '.$bedroom;
					}
				}

			}
		}
		
		if(isset($data['studio']) && isset($data['bedrooms'])) {
		$query->andWhere('ut.name = \'studio\' OR (ut.name = \'# bedroom(s)\' AND '.implode(' OR ', $query_bedrooms).')');
		}
		
		if(!isset($data['studio']) && isset($data['bedrooms'])) {
			$query->andWhere('('.implode(' OR ', $query_bedrooms).')');
		}
		
		//living area
		if($data['area_living_from']>0) {
			$filter[] = "Living area > ".$data['area_living_from'];
			$query->andWhere('u.livingArea > \''.$data['area_living_from'].'\'');
		}
		if($data['area_living_to']>0) {
			$filter[] = "Living area < ".$data['area_living_to'];
			$query->andWhere('u.livingArea < \''.$data['area_living_to'].'\'');
		}
		
		//land area
		if($data['area_land_from']>0) {
			$filter[] = "Land area > ".$data['area_land_from'];
			$query->andWhere('u.landSize > \''.$data['area_land_from'].'\'');
		}
		if($data['area_land_to']>0) {
			$filter[] = "Land area < ".$data['area_land_to'];
			$query->andWhere('u.landSize < \''.$data['area_land_to'].'\'');
		}
		
		//SALE
		if(isset($data['purpose-sale'])) {
			if($data['purpose-sale']=='sale') {
				$filter[] = "Purpose: Sale";
				$query->andWhere('ucc.purpose = \'1\' OR ucc.purpose = \'3\'');
				
				if($data['price_from']>0){
					$filter[] = 'Price from M฿'.$data['price_from'];
					$price = $data['price_from'] * 1000000;
				$query->andWhere('uc.salePrice > \''.$price.'\'');
				}
				if($data['price_to']>0){
					$filter[] = 'Price to M฿'.$data['price_to'];
					$price = $data['price_to'] * 1000000;
					$query->andWhere('uc.salePrice < \''.$price.'\'');
				}
			
			}
		}
		
		// Offplan
		
		if(isset($data['offplan']) && !isset($data['ready'])) {
			$filter[] = 'Offplan';
				$query->andWhere('p.completedOn >= CURRENT_DATE()');
		}
		if(isset($data['ready']) && !isset($data['offplan'])) {
			$filter[] = 'Ready to move in';
			$query->andWhere('p.completedOn <= CURRENT_DATE()');
		}
		
		// Ownership
		$ownership = array();
			if(isset($data['ownership-thai'])) {
				if($data['ownership-thai']=='Thai') {
					$ownership[] = "Thai";
					$query->andWhere('u.ownership LIKE \'%Thai%\'');	
				}
			}
			if(isset($data['ownership-company'])) {
				if($data['ownership-company']=='Company') {
					$ownership[] = "Company";
					$query->andWhere('u.ownership LIKE \'%Company%\'');
				}
				
			}
			if(isset($data['ownership-foreign'])) {
				if($data['ownership-foreign']=='Foreign') {
					$ownership[] = "Foreign";
					$query->andWhere('u.ownership LIKE \'%Foreign%\'');
				}
			}
			if(count($ownership)) {
				$filter[] = 'Ownership: '.implode('/',$ownership);
			}
		
		//sale_type
			if(isset($data['sale_type'])) {
				$query->leftJoin('o.contactTypes', 'oct');
				foreach($data['sale_type'] as $sale_type) {
					switch ($sale_type) {
						case 'own':
							$filter[] = "Powerhouse Properties Development";
							$query->andWhere('o.name LIKE \'%Powerhouse Properties%\'');
							break;
						case 'other':
							$filter[] = "Sale via Developer";
							$query->andWhere('oct.name = \'Developer\'');
							break;
						case 'resale':
							$filter[] = "Private Resale";
							$query->andWhere('oct.name = \'Private Owner\'');
							break;
						case 'agent':
							$filter[] = "Sale via agency";
							$query->andWhere('oct.name = \'Agency\'');
							break;
					}	
				}
			}
		
			//RENT
			if(isset($data['purpose-long']) || isset($data['purpose-short']) || isset($data['purpose-weekly']) || isset($data['purpose-daily'])) {
			
				$query->andWhere('ucc.purpose = \'2\' OR ucc.purpose = \'3\'');
				
				$query_prices = array();
			
				if(isset($data['purpose-long']) ) {
					if($data['purpose-long']=='long') {
						$filter[] = "Purpose: Rental Long Term";
				
						if($data['rent_price_long_from']>0){
							//$query->andWhere('uc.rental1Year > \''.$data['rent_price_long_from'].'\'');
							$query_prices[] = 'uc.rental1Year > \''.$data['rent_price_long_from'].'\'';
						}
						if($data['rent_price_long_to']>0){
							//$query->andWhere('uc.rental1Year < \''.$data['rent_price_long_to'].'\'');
							$query_prices[] = 'uc.rental1Year < \''.$data['rent_price_long_to'].'\'';
						}
							
					}
				}
				if(isset($data['purpose-short'])) {
					if($data['purpose-short']=='short') {
						$filter[] = "Purpose: Rental Short Term";
						//$query->andWhere('ucc.purpose = \'2\' OR ucc.purpose = \'3\'');
							
						if($data['rent_price_short_from']>0){
							//$query->andWhere('uc.rentalMonthly > \''.$data['rent_price_short_from'].'\'');
							$query_prices[] = 'uc.rentalMonthly > \''.$data['rent_price_short_from'].'\'';
						}
						if($data['rent_price_short_to']>0){
							//$query->andWhere('uc.rentalMonthly < \''.$data['rent_price_short_to'].'\'');
							$query_prices[] = 'uc.rentalMonthly < \''.$data['rent_price_short_to'].'\'';
						}
				
					}
				}
				if(isset($data['purpose-weekly'])) {
					if($data['purpose-weekly']=='weekly') {
						$filter[] = "Purpose: Rental Weekly";
						//$query->andWhere('ucc.purpose = \'2\' OR ucc.purpose = \'3\'');
							
						if($data['rent_price_weekly_from']>0){
							//$query->andWhere('uc.rentalWeekly > \''.$data['rent_price_weekly_from'].'\'');
							$query_prices[] = 'uc.rentalWeekly > \''.$data['rent_price_weekly_from'].'\'';
						}
						if($data['rent_price_weekly_to']>0){
							//$query->andWhere('uc.rentalWeekly < \''.$data['rent_price_weekly_to'].'\'');
							$query_prices[] = 'uc.rentalWeekly < \''.$data['rent_price_weekly_to'].'\'';
						}
				
					}
				}
				if(isset($data['purpose-daily'])) {
					if($data['purpose-daily']=='daily') {
						$filter[] = "Purpose: Rental Daily";
						//$query->andWhere('ucc.purpose = \'2\' OR ucc.purpose = \'3\'');
							
						if($data['rent_price_daily_from']>0){
							//$query->andWhere('uc.rentalDaily > \''.$data['rent_price_daily_from'].'\'');
							$query_prices[] = 'uc.rentalDaily > \''.$data['rent_price_daily_from'].'\'';
						}
						if($data['rent_price_daily_to']>0){
							//$query->andWhere('uc.rentalDaily < \''.$data['rent_price_daily_to'].'\'');
							$query_prices[] = 'uc.rentalDaily < \''.$data['rent_price_daily_to'].'\'';
						}
				
					}
				}
				
				if($query_prices) {
					$query->andWhere("(".implode(" OR ", $query_prices).")");
				}
			}
			
		//district
			
			if(isset($data['district']) || $data['distancebeach'] || $data['swimmingpool']) {
				$query->leftJoin('p.address', 'pa');
				$query->leftJoin('pa.district', 'pad');
				$query->leftJoin('u.address', 'ua');
				$query->leftJoin('ua.district', 'uad');
			}
			
			if(isset($data['district'])) {
				foreach ($data['district'] as $key => $link)
				{
					if ($data['district'][$key] == '')
					{
						unset($data['district'][$key]);
					}
				}
				$districts = array();
				$query->andWhere('pad.id IN ('.implode(',',$data['district']).') OR uad.id IN ('.implode(',',$data['district']).')');
					
				foreach($data['district'] as $district) {
					if($district>0) {
						$found = $this->getEntityManager()->getRepository('PHRentalsMainBundle:District')->find($district);
						if($found) $districts[] = $found->getName();
					}
				}
				
				$filter[] = 'Districts: '.implode('/',$districts);
				
			}
			
		//distancebeach
			if($data['distancebeach']) {
				switch ($data['distancebeach']) {
					case 'beach front':
						$filter[] = 'Distance to beach: Beachfront';
						$query->andWhere('pa.distanceToBeach < 30 OR ua.distanceToBeach < 30 ');
						break;
					case 'under 100':
						$filter[] = 'Distance to beach: under 100m';
						$query->andWhere('pa.distanceToBeach <= 100 OR ua.distanceToBeach <= 100 ');
						break;
					case '100-200':
						$filter[] = 'Distance to beach: 100m-200m';
						$query->andWhere('(pa.distanceToBeach >= 100 OR ua.distanceToBeach >= 100) AND (pa.distanceToBeach <= 200 OR ua.distanceToBeach <= 200)');
						break;
					case '100-300':
						$filter[] = 'Distance to beach: 100m-300-m';
						$query->andWhere('(pa.distanceToBeach >= 100 OR ua.distanceToBeach >= 100) AND (pa.distanceToBeach <= 300 OR ua.distanceToBeach <= 300)');
						break;
					case '200-300':
						$filter[] = 'Distance to beach: 200m-300m';
						$query->andWhere('(pa.distanceToBeach >= 200 OR ua.distanceToBeach >= 200) AND (pa.distanceToBeach <= 300 OR ua.distanceToBeach <= 300)');
						break;
					case '250-400':
						$filter[] = 'Distance to beach: 250m-400m';
						$query->andWhere('(pa.distanceToBeach >= 250 OR ua.distanceToBeach >= 250) AND (pa.distanceToBeach <= 400 OR ua.distanceToBeach <= 400)');
						break;
					case '400-more':
						$filter[] = 'Distance to beach: more than 400m';
						$query->andWhere('pa.distanceToBeach >= 400 OR ua.distanceToBeach >= 400');
						break;
				}
				
			}	
			
			if(isset($data['seaview']) || isset($data['furnished'])) {
				$query->leftJoin('u.tags', 'utag');
			}
			if($data['swimmingpool']) {
				$query->leftJoin('pa.tags', 'pat');
				$query->leftJoin('ua.tags', 'uat');
			}
				
			
		//seaview
			if(isset($data['seaview'])) {
				$filter[] = 'Sea View';
				$query->andWhere('utag.name = \'Sea View\'');
			}
			//$this->getEntityManager()->getRepository('PHRentalsMainBundle:District')->find($district)->getName();
			
		//swimming pool
			if(isset($data['swimmingpool'])) {
				switch ($data['swimmingpool']) {
					case 'private':		
						$filter[] = 'Private Swimming Pool';
						$query->andWhere('pat.name = \'private swimming pool\' OR uat.name = \'private swimming pool\'');
						break;
					case 'shared':
						$filter[] = 'Shared Swimming Pool';
						$query->andWhere('pat.name = \'shared swimming pool\' OR uat.name = \'shared swimming pool\'');
						break;
					case 'no':
						//$filter[] = 'No Swimming Pool';
						//$query->andWhere('pat.name NOT LIKE \'%swimming pool\' OR uat.name NOT LIKE \'%swimming pool\'');
						break;
				}
			}
			
			//furnished
			if($data['furnished']) {
				switch ($data['furnished']) {
					case 'fully':
						$filter[] = 'Fully furnished';
						$query->andWhere('utag.name = \'fully furnished\'');
						break;
					case 'partially':
						$filter[] = 'Partially furnished';
						$query->andWhere('utag.name = \'partially furnished\'');
						break;
					case 'not':
						$filter[] = 'Not furnished';
						$query->andWhere('utag.name = \'not furnished\'');
						break;
				}
			}
			
			//furnished
			if($data['is_featured']) {
				switch ($data['is_featured']) {
					case 'Y':
						$filter[] = 'Featured units';
						$query->andWhere('u.featured = \'1\'');
						break;
					case 'N':
						$filter[] = 'Units not featured';
						$query->andWhere('u.featured = \'0\'');
						break;
				}
			}
			
			//-----------------------
			//        EXTRA
			//-----------------------
			
			//rating
			
			//priority
			
			//bathrooms
			if ($data['bathrooms'] > 0) {
				$query->andWhere('u.bathrooms = \''.$data['bathrooms'].'\'');
				$filter[] = "Bathrooms: ".$data['bathrooms'];
			}
			
			// unit tags
			if(isset($data['unitTags'])) {
				if (count($data['unitTags'])>0) {
					foreach($data['unitTags'] as $key => $value) {
						$table = 'utag'.$value;
						$query->leftJoin('u.tags', $table);
						$query->andWhere($table.".id = '".$value."'");
						$filter[] = ucwords($this->getEntityManager()->getRepository('PHRentalsMainBundle:UnitTag')->find($value)->getName());
					}	
				}
			}
			
			// address tags
			if(isset($data['addressTags'])) {
				if (count($data['addressTags'])>0) {
					foreach($data['addressTags'] as $key => $value) {
						$table1 = 'pa2tag'.$value;
						$table2 = 'ua2tag'.$value;
						$query->leftJoin('p.address', 'pa2'.$value);
						$query->leftJoin('u.address', 'ua2'.$value);
						$query->leftJoin('pa2'.$value.'.tags', $table1);
						$query->leftJoin('pa2'.$value.'.tags', $table2);
						$query->andWhere("(".$table1.".id = '".$value."' OR ".$table2.".id = '".$value."')");
						$filter[] = ucwords($this->getEntityManager()->getRepository('PHRentalsMainBundle:AddressTag')->find($value)->getName());
					}
				}
			}
			
			// validated by
			
			if($data['users']>0) {
				$validating_user = $this->getEntityManager()->getRepository('ApplicationSonataUserBundle:User')->find($data['users']);
				$query->andWhere('ucc.validatedByUser = \''.$data['users'].'\'');
				$filter[] = "Validated by ".$validating_user->getUsername();
			}
			
			// validate on
			
			if(isset($data['validated_on_from'])) {
				$validating_date_from = \DateTime::createFromFormat('d/m/Y', $data['validated_on_from'], new \DateTimeZone('UTC'));
				 
				if ($validating_date_from) {
					$validating_date_from->setTime(0,0,0);
					$query->andWhere('ucc.validatedOn >= \''.$validating_date_from->format('Y-m-d').' 00:00:00\'');
					$filter[] = "Validated on from ".$data['validated_on_from'];
				}
			}
			
			if(isset($data['validated_on_to'])) {
				$validating_date_to = \DateTime::createFromFormat('d/m/Y', $data['validated_on_to'], new \DateTimeZone('UTC'));
					
				if ($validating_date_to) {
					$validating_date_to->setTime(0,0,0);
					$query->andWhere('ucc.validatedOn <= \''.$validating_date_to->format('Y-m-d').' 00:00:00\'');
					$filter[] = "Validated on from ".$data['validated_on_to'];
				}
			}
			
			//[validated_on_from] => 01/22/2013 [validated_on_to] => 02/14/2013
			
			
			
			
		$search_string = implode(", ", $filter);
			
		//print_r($qb->getQuery()->getSQL());
		//exit;
		
		$units = $qb->getQuery()->getResult();
	
		return $units;
	}
	
}