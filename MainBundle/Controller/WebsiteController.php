<?php

namespace PHRentals\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use PHRentals\MainBundle\Entity\UnitSize;
use PHRentals\MainBundle\Entity\Unit;
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

/**
 * Website controller.
 *
 * @Route("/website")
 */
class WebsiteController extends Controller
{

    /**
     * Test
     *
     * @Route("/load/{name}", name="website_edit")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
  
    
    /**
     * Featured for main website page
     *
     * @Route("/featured-load-content/{class}", name="website_featured")
     * @Template()
     */

    public function featuredLoadContentAction($class) {
    	
    	$em = $this->container->get('doctrine')->getEntityManager();
    	
    	$qb = $em->createQueryBuilder();
    	
		$query = $qb->select('u')
		->from('PHRentalsMainBundle:Unit','u')
		->leftJoin('u.contracts', 'uc')
		->andWhere('u.active = 1')
		->andWhere('u.featured = \'1\'')
		;
		
		if ($class == 'offplan') {
			$query
			->leftJoin('u.project', 'p')
			->andWhere('p.completedOn >= CURRENT_DATE()');
		} else {		
			$query		
			->leftJoin('u.class', 'ucl')
			->andWhere('ucl.name = \''.$class.'\'');
		}
		
		$query->orderBy('uc.salePrice', 'ASC');

		
		//print_r($qb->getQuery()->getSQL());
		//exit;
			
	    $units = $qb->getQuery()->getResult();
    	
    	return $this->container->get('templating')->renderResponse('PHRentalsMainBundle:Website:featured-load-content.html.twig',
    			array('units' => $units)
    	);
    }
    
    
}
