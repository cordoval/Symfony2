<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use PHRentals\MainBundle\Entity\ContractUnit as ContractEntity;
use PHRentals\MainBundle\Entity\Contact as UnitOwner;
 
class ContractUnitRangesAdmin extends Admin
{
    protected $baseRoutePattern = "/contractunitranges";
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('dateFrom', 'genemu_jquerydate', array('attr' => array('class' => 'hasDatePicker'), 'widget' => 'single_text', 'format' => 'd/M/y', 'required' => false, 'years' => range(date('Y') - 20, date('Y') + 5)))
      ->add('dateTo', 'genemu_jquerydate', array('attr' => array('class' => 'hasDatePicker'), 'widget' => 'single_text', 'format' => 'd/M/y', 'required' => false, 'years' => range(date('Y') - 20, date('Y') + 5)))
      ->add('note', null, array('attr' => array('style' => 'width: 535px;')))
      ->end()
    ;
    
  }
}