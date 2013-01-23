<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
 
class PaymentAdmin extends Admin
{
     protected $baseRoutePattern = "/payments";
     
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('date', 'date', array('required' => true, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
      ->add('amount', 'money', array('grouping' => true, 'currency' => 'THB', 'precision' => 0, 'attr' => array('size' => '5')))
      ->add('paymentType', 'sonata_type_model')
      ->add('notes')
    ->end()
      ;   
      
  }
  
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('date')
      ->add('amount')
      ->add('paymentType', 'sonata_type_model')
      ->add('notes')     
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->add('date')
      ->add('amount')
      ->add('paymentType', 'sonata_type_model')
      ->add('notes')
    ;
  }
 
  public function validate(ErrorElement $errorElement, $object)
  {
  	/*
    $errorElement
      ->with('name')
      ->assertMaxLength(array('limit' => 255))
      ->end()
    ;
    
    // conditional validation, see the related section for more information
    if ($object->getSeaview()) {
    	// abstract cannot be empty when the post is enabled
    	$errorElement
    	->with('price')
    	->assertNotNull()
    	->end()
    	;
    	
    }*/
    
  }
  
}