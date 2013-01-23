<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
 
class UnitImageAdmin extends Admin
{
    protected $baseRoutePattern = "/images";
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('file', 'file', array('required' => false, 'data_class' => 'Symfony\Component\HttpFoundation\File\UploadedFile'))
      //->add('active', null, array('required' => false))
    ;
    
    if ($this->getSubject()) {
    	$formMapper
    	->add('name', 'genemu_plain' , array('disabled' => true, 'required'=>false))
    	->end()
    	;
    }
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