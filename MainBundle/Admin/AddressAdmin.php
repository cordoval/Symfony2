<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use PHRentals\MainBundle\Entity\Address as AddressEntity;
 
class AddressAdmin extends Admin
{
    protected $baseRoutePattern = "/addresses";

    protected function configureRoutes(RouteCollection $collection)
    {
    	$collection->add('calendar', $this->getRouterIdParameter().'/calendar');
    }
    
    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array(
    		'_page' => 1,
    		'_sort_order' => 'ASC',
    		'_sort_by' => 'name'
    );
    
  protected function configureFormFields(FormMapper $formMapper)
  {
  	$query = $this->getModelManager()->getEntityManager('PHRentals\MainBundle\Entity\District')->createQuery('SELECT s FROM PHRentals\MainBundle\Entity\District s ORDER BY s.location, s.name ASC');
  	$querytags = $this->getModelManager()->getEntityManager('PHRentals\MainBundle\Entity\AddressTag')->createQuery('SELECT s FROM PHRentals\MainBundle\Entity\AddressTag s ORDER BY s.group, s.position ASC');
  	 
  	
    $formMapper
      ->add('class')
      ->add('map', null, array('required' => false))
      ->add('gpsLon', null, array('required' => false))
      ->add('gpsLat', null, array('required' => false))
      //'choice', array('required' => false, 'choices' => AddressEntity::getDistanceToBeachList())
      ->add('distanceToBeach', null, array('required' => false))
      ->add('district', 'sonata_type_model', array('required' => false, 'query' => $query), array('edit' => 'standard'))
      ->add('tags', 'sonata_type_model', array('query' => $querytags, 'expanded' => true, 'multiple' => true, 'by_reference' => false, 'attr' => array ('class' => 'taglist')))
    ->with('Detailed Address', array('collapsed' => false))
      ->add('text', null, array('required' => false))
      ->add('adrStreet1', null, array('label' => 'Street No', 'required' => false))
      ->add('adrStreet2', null, array('label' => 'Moo', 'required' => false))
      ->add('adrStreet3', null, array('label' => 'Street Name', 'required' => false))
      ->add('adrStreet4', null, array('label' => 'Trok/Soi', 'required' => false))
      ->add('adrStreet5', null, array('label' => 'Tambon/Sub-district', 'required' => false))
      ->add('adrStreet6', null, array('label' => 'Amphur/District', 'required' => false))
      ->add('adrCity', null, array('label' => 'City', 'required' => false))
      ->add('adrProvince', null, array('label' => 'Province', 'required' => false))
      ->add('adrZip', null, array('label' => 'Zip Code', 'required' => false))
      ->add('adrCountry', null, array('label' => 'Country', 'required' => false))
    ->end()
    ;
  }
  
  /*
  protected function configureShowFields(ShowMapper $filter)
  {
  	 
  	$filter
  	->add('name')
  	->add('addressType')
      ->add('map')
      ->add('gpsLon')
      ->add('gpsLat')
      ->add('distanceToBeach')
  	->add('district')
  	->add('tags')
  	->add('adrStreet1', null, array('label' => 'Street No'))
  	->add('adrStreet2', null, array('label' => 'Moo'))
  	->add('adrStreet3', null, array('label' => 'Street Name'))
  	->add('adrStreet4', null, array('label' => 'Trok/Soi'))
  	->add('adrStreet5', null, array('label' => 'Tambon/Sub-district'))
  	->add('adrStreet6', null, array('label' => 'Amphur/District'))
  	->add('adrCity', null, array('label' => 'City'))
  	->add('adrProvince', null, array('label' => 'Province'))
  	->add('adrZip', null, array('label' => 'Zip Code'))
  	->add('adrCountry', null, array('label' => 'Country'))
  	->end();
  }
  */
  
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('district')
    ;
  }

  
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->add('class')
      ->add('district')
      ->add('units', 'string', array('label' => 'Nb of Units', 'template' => 'PHRentalsMainBundle:Admin:number_of_units.html.twig'))
      ->add('address', 'string', array('template' => 'PHRentalsMainBundle:Admin:address-text.html.twig'))
      ->add('_action', 'actions', array(
      		'actions' => array(
      				'edit' => array()
      		)))
    ;
  }
   
  public function getExportFields()
  {
  	$results = $this->getModelManager()->getExportFields($this->getClass());
  
  	// Need to add again our foreign key field here
  	$results[] = 'class';  //<--- category is the name of the field FK to category table that I want to include.
  	$results[] = 'district';
  	
  	return $results;
  }
  
  public function getExportFormats()
  {
  	return array(
  			'csv', 'xls'
  	);
  }
  
  public function getBatchActions()
  {
  	// retrieve the default (currently only the delete action) actions
  	//$actions = parent::getBatchActions();
  	$actions = null;
  
  	// check user permissions
  	if($this->hasRoute('edit') && $this->isGranted('EDIT') && $this->hasRoute('delete') && $this->isGranted('DELETE')){
  		$actions['merge']=array(
  				'label'            => 'Merge Address',
  				'ask_confirmation' => true // If true, a confirmation will be asked before performing the action
  		);
  
  	}
  
  	return $actions;
  }
 
  public function validate(ErrorElement $errorElement, $object)
  {
  	/*
    $errorElement
      ->with('address')
      ->assertMaxLength(array('limit' => 255))
      ->end()
    ;*/
  }
  
  public function getTemplate($name)
  {
  	switch ($name) {
  		case 'edit':
  			return 'PHRentalsMainBundle:Admin:address-edit.html.twig';
  			break;
  		default:
  			return parent::getTemplate($name);
  			break;
  	} 
  }
  
}