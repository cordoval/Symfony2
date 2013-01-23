<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use PHRentals\MainBundle\Entity\Outside as OutsideEntity;

class OutsideAdmin extends Admin
{
    
    protected $baseRoutePattern = "/externalupdate";
    
    
    protected function configureRoutes(RouteCollection $collection)
    {
    	$collection->remove('create');
    	$collection->add('integrate', $this->getRouterIdParameter().'/integrate');
    	$collection->add('imagedelete', $this->getRouterIdParameter().'/imagedelete/{file}');
    	$collection->add('imagedeleteall', $this->getRouterIdParameter().'/imagedeleteall');
    }
    
    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array(
    		'_page' => 1,
    		'_sort_order' => 'DESC',
    		'_sort_by' => 'status'
    );
    
    public function getFilterParameters()
    {
    	$parameters = parent::getFilterParameters();

    	if(!array_key_exists('status',$parameters)) {
    	$parameters['status']['type'] = '2';
    	$parameters['status']['value'] = '4/4 - listing imported';
    	}
    	//filter[status][type]=2&filter[status][value]=4/4
    
    	return $parameters;
    }
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
        ->add('status', null , array('disabled' => true))
        ->add('contact', null, array('disabled' => true))
        ->add('contract', null, array('disabled' => true))
        ->add('unit', null, array('disabled' => true))
        ->add('notes')
	->end()
    ;
    
    if ($this->getSubject()->getId()) {
    	$formMapper
      		->add('validatedOn', 'genemu_plain', array('date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
      		->add('validatedByUser', 'genemu_plain', array('label' => 'Validated by', 'disabled' => true, 'data_class' => 'Application\Sonata\UserBundle\Entity\User', 'required'=>false))
      		->add('updatedOn', 'genemu_plain', array('date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
      		->add('createdByUser', 'genemu_plain', array('label' => 'Created by', 'disabled' => true, 'data_class' => 'Application\Sonata\UserBundle\Entity\User', 'required'=>false))
      		->add('createdOn', 'genemu_plain', array('date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
            ->add('link')
    	->end()
    	;
    }
 
    
    //$formMapper->get('active')->setData(true);
  }
  
  public function getNewInstance()
  {
  	$instance = parent::getNewInstance();

  	return $instance;
  }
 
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      //->add('status')      
      ->add('status', 'doctrine_orm_choice', array(), 'choice', array('required' => false, 'choices' => OutsideEntity::getStatusList()))
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('contact')
      ->add('unit', 'string', array('label' => 'Unit', 'template' => 'PHRentalsMainBundle:Admin:outside-unit.html.twig'))
      ->add('contract', 'string', array('label' => 'Contract', 'template' => 'PHRentalsMainBundle:Admin:outside-contract.html.twig'))
      ->add('createdOn')
      ->add('createdBy', 'string', array('label' => 'By', 'template' => 'PHRentalsMainBundle:Admin:outside-createdby.html.twig'))
      ->add('updatedOn')
      ->add('status', 'string', array('label' => 'Status', 'template' => 'PHRentalsMainBundle:Admin:outside-status.html.twig'))
      ->add('link', 'string', array('label' => 'Link', 'template' => 'PHRentalsMainBundle:Admin:outside-link.html.twig'))
      ->add('action', 'string', array('label' => 'Action', 'template' => 'PHRentalsMainBundle:Admin:outside-action.html.twig'))
    ;
  }
  
  public function getExportFormats()
  {
  	return array(
  			''
  	);
  }
  
  public function getBatchActions()
  {
  	// retrieve the default (currently only the delete action) actions
  	//$actions = parent::getBatchActions();
  	$actions = null;
  
  	return $actions;
  }
  
  public function prePersist($contact)
  {
  	/*
  	$user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();

  	if ($contact->getValidation() != '') {
  		$contact->setValidatedByUser($user);
  	}
  	*/
  }
  
  public function preUpdate($contact)
  {
  	/*
  	$user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
  	
  	if ($contact->getValidation() != '') {
  		$contact->setValidatedByUser($user);
  	}
  	 */
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
  		case 'list':
  			return 'PHRentalsMainBundle:Admin:outside-list.html.twig';
  			break;
  		case 'edit':
  			return 'PHRentalsMainBundle:Admin:outside-edit.html.twig';
  			break;
  		default:
  			return parent::getTemplate($name);
  			break;
  	}
  }
  
}