<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use PHRentals\MainBundle\Entity\Contract as ContractEntity;
use PHRentals\MainBundle\Entity\Contact as UnitOwner;
use PHRentals\MainBundle\Entity\ContractUnit;
 
class SearchAdmin extends Admin
{
    protected $baseRoutePattern = "/search";
    
    protected $baseRouteName = "units";
    
    protected function configureRoutes(RouteCollection $collection)
    {
    	$collection->remove('show');
    	$collection->remove('edit');
    	$collection->remove('delete');
    	$collection->remove('list');
    	$collection->add('units', 'units');
    }
    
    /**
     * Default Datagrid values
     *
     * @var array
     */
      
  
  public function getTemplate($name)
  {
  	switch ($name) {
  		default:
  			return 'PHRentalsMainBundle:Admin:unit-search.html.twig';
  			break;
  	}
  	
  }
}