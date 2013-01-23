<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
 
class ReservationAdmin extends Admin
{
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('dateFrom', 'date', array('required' => true, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
      ->add('dateTo', 'date', array('required' => true, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
      ->add('unit', 'sonata_type_model')
      ->add('pricePerNight', 'money', array('read_only' => true, 'required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0, 'attr' => array('class' => 'thb_input')))
      ->add('nightNb', null, array('read_only' => true))
      ->add('totalCalculated', 'money', array('read_only' => true, 'required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0, 'attr' => array('class' => 'thb_input')))
      ->add('total', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0, 'attr' => array('class' => 'thb_input')))
    	->end()
    	;  
    /*
        if(!$this->isChild()) {
            $formMapper->add('post', 'sonata_type_model', array(), array('edit' => 'list'));
        }
     */
  }
  
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('dateFrom')
      ->add('dateTo')
      ->add('unit')     
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->add('dateFrom')
      ->add('dateTo')
      ->add('unit') 
      ->add('rate', 'string', array('template' => 'PHRentalsMainBundle:Admin:reservation-rates.html.twig'))
    ;
  }
  
  public function preUpdate($reservation)
  {
  	//$reservation->setPricePerNight('1000');
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