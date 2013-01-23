<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use PHRentals\MainBundle\Entity\Owner as UnitOwner;
 
class TenantAdmin extends Admin
{
    
    protected $baseRoutePattern = "/tenants";
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('prefixName', 'choice', array('required' => false, 'choices' => UnitOwner::getPrefixList()))
      ->add('firstName', null, array('required' => true))
      ->add('lastName', null, array('required' => true))
      ->add('age', null, array('required' => false))
      ->add('nationality', 'country', array('required' => false))
      ->add('notes', null, array('required' => false))
      ->add('tel', null, array('required' => false))
      ->add('email', null, array('required' => false))
    ->with('Address', array('collapsed' => true))
      ->add('adrStreet1', null, array('label' => 'House/Unit/Floor', 'required' => false))
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
      //->add('active', null, array('required' => false))
    ;
    
    //$formMapper->get('active')->setData(true);
  }
  
  public function getNewInstance()
  {
  	$instance = parent::getNewInstance();
  	$instance->setAdrCountry('Thailand');
  	return $instance;
  }
 
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('firstName')
      ->add('lastName')
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('firstName')
      ->addIdentifier('lastName')
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