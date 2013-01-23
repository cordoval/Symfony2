<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
 
class AddressTagAdmin extends Admin
{
    protected $baseRoutePattern = "/addresstags";
    
    protected $maxPerPage = 100;
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('name', null, array('required' => true))
      ->add('position')
      ->add('group')
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
      ->addIdentifier('position')
      ->addIdentifier('group')
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