<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
 
class UnitSameAdmin extends Admin
{
    protected $baseRoutePattern = "/UnitSames";
    
    protected function configureRoutes(RouteCollection $collection)
    {
    	$collection->add('calendar', $this->getRouterIdParameter().'/calendar');
    }
	
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('name', null, array('required' => true))
      ->add('units', 'sonata_type_model', array('expanded' => true, 'multiple' => true, 'by_reference' => false))
      ;
  }
  
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('name')
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('name')
      ->add('units', 'string', array('label' => 'Nb of Units', 'template' => 'PHRentalsMainBundle:Admin:number_of_units.html.twig'))
      ->add('_action', 'actions', array(
      		'actions' => array(
      				'edit' => array(),
      				'calendar' => array()
      		)))
    ;
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
}