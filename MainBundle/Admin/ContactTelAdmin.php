<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class ContactTelAdmin extends Admin
{
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('tel', null, array('required' => true))
      ->add('note', null, array('required' => false))
    ->end()
    ;
  }

 
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('tel')
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('tel')
      ->add('note')
    ->add('_action', 'actions', array(
        'actions' => array(
            'edit' => array()
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
    ;
    */
  }
}