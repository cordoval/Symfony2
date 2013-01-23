<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ContactEmailAdmin extends Admin
{

	protected function configureRoutes(RouteCollection $collection)
	{
		$collection->add('createinline', 'createinline');
	}
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('email', null, array('required' => true))
      ->add('note', null, array('required' => false))
    ->end()
    ;
  }

 
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('email')
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('email')
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