<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use PHRentals\MainBundle\Form\Type;

 
class CustomerAdmin extends Admin
{
    protected $baseRoutePattern = "/renters";
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('name')
      ->add('email', 'email', array('required' => false))
      ->add('nationality') // 'country'
      ->add('address')
      ->add('telephone1')
      ->add('telephone2')
      ->add('telephone3')
      ->add('passport')
      ->add('last_action', 'date', array('required' => false, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
      ->add('notes')
      ->add('active')
      //->add('active', null, array('required' => false))
    ;
  }
 
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('name')
      ->add('last_action', 'doctrine_orm_datetime')
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('name')
      ->add('email')
      ->add('nationality', 'country')
      ->add('active')
    ->add('_action', 'actions', array(
        'actions' => array(
            'edit' => array()
        )))
    ;
  }
 
  public function validate(ErrorElement $errorElement, $object)
  {
    $errorElement
      ->with('name')
      ->assertMaxLength(array('limit' => 255))
      ->end()
    ;
  }
}