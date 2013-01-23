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
 
class ContractUnitAdmin extends Admin
{
    protected $baseRoutePattern = "/contractunits";
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('contract', 'sonata_type_model_list')
      ->add('unit', 'sonata_type_model_list')
    ->with('Availability', array('collapsed' => false))
      ->add('incontract', null, array('label' => 'In Contract?', 'required' => false))
      //->add('availableFrom', 'date', array('required' => false, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
      //->add('moveinOn', 'date', array('required' => false, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
      ->add('notes')
      ->add('availableFrom', 'genemu_jquerydate', array('label' => 'Available From (date)', 'attr' => array('class' => 'hasDatePicker'), 'widget' => 'single_text', 'format' => 'd/M/y', 'required' => false, 'years' => range(date('Y') - 20, date('Y') + 5)))
      //->add('moveinOn', 'genemu_jquerydate', array('widget' => 'single_text', 'format' => 'd/M/y', 'required' => false, 'years' => range(date('Y') - 20, date('Y') + 5)))
    	
      ->add('ranges','sonata_type_collection', array('label' => 'Not available ranges', 'required' => false, 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table'))
      ->end()
     ->with('Property Pricing - Sale', array('collapsed' => false))
      ->add('salePricePerSqm', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      ->add('salePrice', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      //->add('salePriceWords')
      ->add('negotiable', null, array('label' => 'Negotiable'))
      ->add('transferFeeBy', 'choice', array('label' => 'Transfer Fee', 'required' => false, 'choices' => ContractEntity::getTransferFeeByList()))
      ->end()
      ->with('Property Pricing - Rent', array('collapsed' => false))
      ->add('deposit')
      //->add('depositInWords')
      //->add('maxRepairCostPerMonth')
      //->add('paymentTypes', 'sonata_type_model', array('expanded' => true, 'multiple' => true, 'by_reference' => false))
      //->add('payment', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      //->add('dueDatePayment')
      //->add('daysPayable')
      ->add('rentalDaily', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      ->add('rentalWeekly', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      ->add('rentalMonthly', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      ->add('rental3Months', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      ->add('rental6Months', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      ->add('rental1Year', 'money', array('required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
      //->add('rentalMonthlyWords', null, array('label' => 'Rental Monthly Words'))
      ->add('extraNotes')
      ->add('utilities')
      ->add('conditions')
      ->add('checkinTimes')
      ->add('checkoutTimes')
      ->end()
      ->with('Visits', array('collapsed' => false))
      ->add('inspection')
      //->add('keysAtLevel', 'choice', array('label' => 'Keys At', 'required' => false, 'choices' => ContractEntity::getkeysAtLevelList()))
      ->add('keysAtText', null, array('label' => 'Keys (remarks)'))
      ->end()
      ->with('Caretaker', array('collapsed' => false))
      ->add('isOwnerCaretaker')
      ->add('caretaker')
      ->add('caretakerPhone')
      ->add('caretakerEmail')
      ->end()

      //->add('active', null, array('required' => false))
    ->setHelps(array(
    'incontract' => $this->trans('Uncheck if the unit is sold or not available for sale or rent anymore.'),
    'inspection' => $this->trans('Exact description of inspection procedure (where is the key, who to call, how get in etc).'),
    'isOwnerCare' => $this->trans('is the owner the daily caretaker? if not :'),
    'dueDatePayment' => $this->trans('Day of the month, ex: 2nd, 5th.'),
    'daysPayable' => $this->trans('No.of Days within payable due date.'),
    'agencyFee Agency' => $this->trans('Fee rate (Percent %)'),
    'agencyDepositRate' => $this->trans('Deposit/Installment Agency rate (%)'),
    'agent' => $this->trans('For Leese Agreement, the authorized person as per the Power of Attorney.'),
    'deposit' => $this->trans('These values for Holiday Rental:'),
    'rentalMonthly' => $this->trans('These values for Long Term Rental:'),
    'salePricePerSqm' => $this->trans('Calculated from Sale Price and Living Area (sqm).'),
    ))
    ;
    
    
    if ($this->getSubject()->getId()) {
    	
    	$formMapper
    	->with('Lease', array('collapsed' => false))
    	->add('leaseStartOn', 'date', array('required' => false, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
    	->add('leaseNbMonths')
    	->add('leaseAgreementDate', 'date', array('required' => false, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
    	->add('agent')
    	->end();
    	
    }
    
    
    
  }
 
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('unit')
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('unit.pRef')
      ->addIdentifier('contract.kRef')
      ->add('_action', 'actions', array(
      		'actions' => array(
      				'edit' => array()
      		)))
    ;
  }
  
  public function getNewInstance()
  {
  	$instance = parent::getNewInstance();
  	
  	if ($this->getRequest()->getMethod() == 'GET') {
  	
  	$contract_id = $this->getRequest()->get('contract_id');
  	
  	//$contract = $this->getModelManager()->getEntityManager('PHRentals\MainBundle\Entity\Contract')->find('1');
  	$instance->setContract($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('PHRentals\MainBundle\Entity\Contract')->find($contract_id));
  	
  	 
  	//$instance->setContract($contract);
  	}  	
  	
  	$instance->setTransferFeeBy('50/50 Owner and Buyer');
  	
  	/*
  	 $instance->setHighSeason('0.2');
  	*/
  	return $instance;
  }
  
   
  
  public function whenUpdating($contract_unit)
  {
  	
  	$helper = $this->getConfigurationPool()->getContainer()->get('phrentals.helper.prices');
  	
  	if(!$contract_unit->getSalePricePerSqm() && $contract_unit->getSalePrice() && $contract_unit->getUnit()->getLivingArea()) {
  		$contract_unit->setSalePricePerSqm(round($contract_unit->getSalePrice()/$contract_unit->getUnit()->getLivingArea(),2));
  	}
  	
  	if(!$contract_unit->getIncontract()) {
  		
  		$unit = $contract_unit->getUnit();
  		$unit->setActive(false);
  		$this->getModelManager()->getEntityManager('PHRentalsMainBundle:Unit')->persist($unit);
  		$this->getModelManager()->getEntityManager('PHRentalsMainBundle:Unit')->flush();
  	}
  	
  }
  
  public function prePersist($contract_unit)
  {
  	$this->whenUpdating($contract_unit);
  }
  
  public function preUpdate($contract_unit)
  {
  	$this->whenUpdating($contract_unit);
  }
  	
  public function validate(ErrorElement $errorElement, $object)
  {
    /*
     $errorElement
      ->with('name')
      ->assertMaxLength(array('limit' => 255))
      ->end()
    ;*/
  }
  
  public function getTemplate($name)
  {
  	switch ($name) {
  		case 'edit':
  			return 'PHRentalsMainBundle:Admin:contract-unit-edit.html.twig';
  			break;
  		default:
  			return parent::getTemplate($name);
  			break;
  	}
  	 
  }
}