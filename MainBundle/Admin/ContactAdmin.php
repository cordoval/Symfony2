<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use PHRentals\MainBundle\Entity\Contact as UnitOwner;

class ContactAdmin extends Admin
{
    
    protected $baseRoutePattern = "/contacts";
    
    protected function configureRoutes(RouteCollection $collection)
    {
    	//$collection->add('search', 'search');
    	$collection->add('createUpdateLink', '{unit_id}/updatelink');
    	$collection->add('createNewUpdateLink', $this->getRouterIdParameter().'/newupdatelink');
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
    $formMapper
      ->add('name', null, array('required' => true))
      ->add('id', 'genemu_plain' , array('disabled' => true, 'required'=>false))
      ->add('contactTypes', 'sonata_type_model', array('attr' => array ('class' => 'columns-contact'), 'expanded' => true, 'multiple' => true, 'by_reference' => false))
      ->add('markets', 'sonata_type_model', array('attr' => array ('class' => 'columns-contact'), 'expanded' => true, 'multiple' => true, 'by_reference' => false))
      ->add('devTypes', 'sonata_type_model', array('attr' => array ('class' => 'columns-contact'), 'expanded' => true, 'multiple' => true, 'by_reference' => false))
      ->add('web', null, array('required' => false))
      ->add('tels','sonata_type_collection', array('label' => 'Telephone No', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table'))
      ->add('emails','sonata_type_collection', array('label' => 'Email', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table'))
      ->add('reps','sonata_type_collection', array('label' => 'Representatives (Manager, Sales, Agent, etc)', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table'))
      //->add('responsive', 'choice', array('required' => false, 'choices' => UnitOwner::getResponsiveList())) 
      	//->add('units','sonata_type_collection', array('label' => 'Units', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table', 'sortable' => 'position'))
      ->end()
    //->with('Projects Involved in', array('collapsed' => true))
    //->add('projects','sonata_type_collection', array('label' => 'Projects', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table'))
    
    //->add('projects',null, array('attr' => array ('class' => 'columns-ppb'), 'expanded' => true, 'multiple' => true, 'by_reference' => false))
    //->end()
    ->with('Owner Details', array('collapsed' => false))
      ->add('prefixName', 'choice', array('required' => false, 'choices' => UnitOwner::getPrefixList()))
      ->add('firstName', null, array('required' => false))
      ->add('lastName', null, array('required' => false))
      ->add('age', null, array('required' => false))
      ->add('nationality', null, array('required' => false))
      ->add('addressHome', null, array('required' => false))
    ->end()
    ->with('Thai Address Details', array('collapsed' => false))
    	->add('address', null, array('label' => 'Address in 1 line', 'required' => false))
	    ->add('addrThaiStreet1', null, array('label' => 'No', 'required' => false))
	    ->add('addrThaiStreet2', null, array('label' => 'Moo', 'required' => false))
	    ->add('addrThaiStreet3', null, array('label' => 'Street Name', 'required' => false))
	    ->add('addrThaiStreet4', null, array('label' => 'Trok/Soi', 'required' => false))
	    ->add('addrThaiStreet5', null, array('label' => 'Tambon/Sub-district', 'required' => false))
	    ->add('addrThaiStreet6', null, array('label' => 'Amphur/District', 'required' => false))
	    ->add('addrThaiCity', null, array('label' => 'City', 'required' => false))
	    ->add('addrThaiProvince', null, array('label' => 'Province', 'required' => false))
	    ->add('addrThaiZip', null, array('label' => 'Zip Code', 'required' => false))
	    ->add('addrThaiCountry', null, array('label' => 'Country', 'required' => false))
	  ->with('Internal', array('collapsed' => false))
	    ->add('responsive', 'choice', array('required' => false, 'choices' => UnitOwner::getResponsiveList()))
	    ->add('validation', 'choice', array('required' => false, 'choices' => UnitOwner::getValidationList()))
	    ->add('notes', null, array('required' => false))
	    ->add('validatedByUser', 'genemu_plain', array('label' => 'Validated by', 'disabled' => true, 'data_class' => 'Application\Sonata\UserBundle\Entity\User', 'required'=>false))
      	->end()
	->end()
    ;
    
    if ($this->getSubject()->getId()) {
    	$formMapper
    	->with('Internal')
    	->add('ownerRef', null, array('required' => false))
    	->add('oldOwnerRef', null, array('required' => false))
    	->add('createdOn', 'genemu_plain', array('date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
      	->add('updatedOn', 'genemu_plain', array('date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
      	->end()
    	;
    }
    
    //$formMapper->get('active')->setData(true);
  }
  
  public function getNewInstance()
  {
  	$instance = parent::getNewInstance();
  	//$instance->setAdrThaiCountry('Thailand');
  	$instance->setOwnerRef($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass())->findNextRef());
  	 
  	return $instance;
  }
 
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('name')
      ->add('ownerRef')
      ->add('contactTypes')
      /*->add('representatives.name')
      ->add('properties.name')
      ->add('properties.pRef')
      ->add('emails.email')
      ->add('tels.tel')*/
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->add('id', 'string', array('label' => 'ID', 'template' => 'PHRentalsMainBundle:Admin:list-id.html.twig'))
      ->addIdentifier('name')
      ->addIdentifier('ownerRef')
      ->add('types', 'string', array('label' => 'Type(s)', 'template' => 'PHRentalsMainBundle:Admin:contact_list_types.html.twig'))
      ->add('units', 'string', array('label' => 'Nb of Units', 'template' => 'PHRentalsMainBundle:Admin:number_of_units.html.twig'))
      ->add('validation')
      ->add('createdOn')
    ;
  }
  
  public function getExportFormats()
  {
  	return array(
  			'csv', 'xls'
  	);
  }
  
  
  public function getExportFields()
  {
  	$results = $this->getModelManager()->getExportFields($this->getClass());
  
  	// Need to add again our foreign key field here
  	
  	$results = array_diff($results, array("notes", "source"));
  	/*
  	$results[] = 'contactTypes';  //<--- category is the name of the field FK to category table that I want to include.
  	$results[] = 'tels';
  	$results[] = 'emails';
  	$results[] = 'representatives';
  	$results[] = 'units';
  	*/
  	 
  	return $results;
  }
  
  
  public function getBatchActions()
  {
  	// retrieve the default (currently only the delete action) actions
  	//$actions = parent::getBatchActions();
  	$actions = null;
  
  	// check user permissions
  	if($this->hasRoute('edit') && $this->isGranted('EDIT') && $this->hasRoute('delete') && $this->isGranted('DELETE')){
  		$actions['merge']=array(
  		'label'            => 'Merge Contacts',
  		'ask_confirmation' => true // If true, a confirmation will be asked before performing the action
  		);
  
  	}
  
  	return $actions;
  }
  
  public function prePersist($contact)
  {
  	$user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();

  	if ($contact->getValidation() != '') {
  		$contact->setValidatedByUser($user);
  	}
  	
  }
  
  public function preUpdate($contact)
  {
  	$user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
  	
  	if ($contact->getValidation() != '') {
  		$contact->setValidatedByUser($user);
  	}
  	 
  }
 
  public function validate(ErrorElement $errorElement, $object)
  {
  	/*
    $errorElement
      ->with('address')
      ->assertMaxLength(array('limit' => 255))
      ->end()
    ;
    */
  }
  
  public function getTemplate($name)
  {
  	switch ($name) {
  		case 'edit':
  			return 'PHRentalsMainBundle:Admin:contact-edit.html.twig';
  			break;
  		default:
  			return parent::getTemplate($name);
  			break;
  	}
  }
  
}