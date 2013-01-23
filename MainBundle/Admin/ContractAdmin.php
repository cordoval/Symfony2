<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use PHRentals\MainBundle\Entity\Contract as ContractEntity;
use PHRentals\MainBundle\Entity\Contact as UnitOwner;
use PHRentals\MainBundle\Entity\ContractUnit;
 
class ContractAdmin extends Admin
{
    protected $baseRoutePattern = "/contracts";
    
    protected function configureRoutes(RouteCollection $collection)
    {
    	//$collection->remove('show');
    	$collection->add('listing', $this->getRouterIdParameter().'/listing');
    	$collection->add('ownerEmail', $this->getRouterIdParameter().'/email');
    	$collection->add('status', $this->getRouterIdParameter().'/status');
    	$collection->add('duplicate', $this->getRouterIdParameter().'/duplicate');
    	$collection->add('createPdf', $this->getRouterIdParameter().'/pdf');
    	$collection->add('createLeasePdf', $this->getRouterIdParameter().'/leasepdf');
    	$collection->add('publishContract', $this->getRouterIdParameter().'/publish');
    }
    
    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array(
    		'_page' => 1,
    		'_sort_order' => 'DESC',
    		'_sort_by' => 'kRef'
    );
      
  protected function configureFormFields(FormMapper $formMapper)
  {
  	
  	$query_purpose = $this->getModelManager()->getEntityManager('PHRentals\MainBundle\Entity\ContractPurpose')->createQuery('SELECT s FROM PHRentals\MainBundle\Entity\ContractPurpose s ORDER BY s.id ASC');
  	
    $formMapper
    ->with('Main Info')
      ->add('kRef', null, array('required' => true))
      ->add('status')
      ->add('agreementDate', 'genemu_jquerydate', array('attr' => array('class' => 'hasDatePicker'), 'widget' => 'single_text', 'format' => 'd/M/y', 'required' => true))
      //->add('agreementDate', 'date', array('label' => 'Agreement Date', 'required' => false, 'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker')))
      ->add('purpose', 'sonata_type_model', array('required' => true, 'query' => $query_purpose), array('edit' => 'standard'))
      ->add('origin', 'choice', array('required' => false, 'choices' => ContractEntity::getOriginList()))
      ->add('remarks')
      //->add('owner', 'sonata_type_model_list', array('required' => false))
      ->add('owner', 'genemu_jqueryautocompleter_entity', array(
      		'route_name' => 'ajax_owner',
      		'class' => 'PHRentals\MainBundle\Entity\Contact'
      ))
      //->add('units','sonata_type_collection', array('label' => 'Units', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table'))
      //->add('units','sonata_type_model', array('required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false))
      //->add('unitNb')
      //->add('units','sonata_type_collection', array('label' => 'Units', 'by_reference' => false, 'error_bubbling' => false), array('edit' => 'inline','inline' => 'table'))
      
      ->end()
    ->with('Commission')
      ->add('commission', 'choice', array('label' => 'Sale Commission', 'required' => false, 'choices' => ContractEntity::getCommissionList()))
      ->add('agencyFee', null, array('label' => 'Agency Fee (%)'))
      //->add('agencyFeeWords', null, array('label' => 'Agency Fee (words)'))
      ->add('agencyDepositRate', null, array('label' => 'Agency Deposit Rate (%)'))
      ->add('commNote', null, array('label' => 'Commission Remarks', 'required' => false))
      ->end()
    ->with('Signature')
      ->add('isContractSigned', null, array('required' => false))
      ->add('dateContractSigned', 'genemu_jquerydate', array('widget' => 'single_text', 'format' => 'd/M/y', 'required' => false))
      ->add('dateExpiration', 'genemu_jquerydate', array('widget' => 'single_text', 'format' => 'd/M/y', 'required' => false))
      ->end()
    ->setHelps(array(
      		/*
      		 'name' => $this->trans('Some advice about what to put there.'),
    		'inspection' => $this->trans('Exact description of inspection procedure (where is the key, who to call, how get in etc).'),
    		'isOwnerCare' => $this->trans('is the owner the daily caretaker? if not :'),
    		'dueDatePayment' => $this->trans('Day of the month, ex: 2nd, 5th.'),
    		'daysPayable' => $this->trans('No.of Days within payable due date.'),
    		'agencyFee Agency' => $this->trans('Fee rate (Percent %)'),
    		'agencyDepositRate' => $this->trans('Deposit/Installment Agency rate (%)'),
    		'agent' => $this->trans('For Leese Agreement, the authorized person as per the Power of Attorney.'),
    		*/
    		
      ))
      ;
      
      if ($this->getSubject()->getId()) {
      	$formMapper
      	
      	->with('Dates')
      	->add('validatedByUser', null, array('required' => false, 'label' => 'Validated by'))
      	->add('validatedOn', 'genemu_plain', array('date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
      	->add('updatedByUser', 'genemu_plain', array('label' => 'Modified by', 'disabled' => true, 'data_class' => 'Application\Sonata\UserBundle\Entity\User', 'required'=>false))
      	->add('updatedOn', 'genemu_plain', array('date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
      	->add('createdByUser', 'genemu_plain', array('label' => 'Created by', 'disabled' => true, 'data_class' => 'Application\Sonata\UserBundle\Entity\User', 'required'=>false))
      	->add('createdOn', 'genemu_plain', array('date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
      	->end()
      	;
      }     
      
  }
 
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('kRef')
      ->add('status')
      ->add('purpose')
      //->add('address')
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('kRef')
      ->addIdentifier('purpose', 'string', array('label' => 'Purpose', 'template' => 'PHRentalsMainBundle:Admin:contract-list-purpose.html.twig'))
      ->add('owner')
      ->add('status', 'string', array('label' => 'Status', 'template' => 'PHRentalsMainBundle:Admin:contract-list-status.html.twig'))
      ->add('units', 'string', array('label' => 'Units', 'template' => 'PHRentalsMainBundle:Admin:contract-list-units.html.twig'))
      //->add('custom', 'string', array('label' => 'High/Peak', 'template' => 'PHRentalsMainBundle:Admin:highseason.html.twig'))
      ->add('_action', 'actions', array(
        'actions' => array(
            'edit' => array(),
        	'createPdf' => array(),
        )))
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
  */
    
  }
  
  public function getNewInstance()
  {
  	$instance = parent::getNewInstance();
  	$instance->setKRef($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass())->findNextRef());
  	$date = new \DateTime('now');
  	$instance->setAgreementDate($date);
  	$instance->setStatus($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('PHRentalsMainBundle:ContractStatus')->find('3'));
  	//$instance->setAgency('Powerhouse Properties Co., Ltd.');
  	//$instance->setOwnerAdrThaiCountry('Thailand');
  	//$instance->setAddressCountry('Thailand');
  	//$instance->setAgent('June Bernard');
  	//$instance->setUnitNb(1);
  	
  	$user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
  	$instance->setValidatedByUser($user);

  	return $instance;
  }
  
  public function getExportFields()
  {
  	$results = $this->getModelManager()->getExportFields($this->getClass());
  
  	// Need to add again our foreign key field here
  	$results[] = 'owner';  //<--- category is the name of the field FK to category table that I want to include.
  	$results[] = 'address';
  	$results[] = 'paymentTypes';
  	$results[] = 'tags';
  	
  	return $results;
  }
  
  public function getExportFormats()
  {
        return array(
            'csv', 'xls'
        );
  }
  
public function whenUpdating($contract)
  {
  	$user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
  	$contract->setUpdatedByUser($user);
  	
  	$helper = $this->getConfigurationPool()->getContainer()->get('phrentals.helper.prices');
  	
  	if(!$contract->getAgencyFeeWords() && $contract->getAgencyFee()) {
  		$contract->setAgencyFeeWords($helper->noToWords($contract->getAgencyFee())." percent");
  	}
  	
  	if($contract->getStatus()->getId() > 7) {
  		$contract->setValidatedByUser($user);
  		$date = new \DateTime('now');
  		$contract->setValidatedOn($date);
  	}
  	
  	$original = (object) $this->getModelManager()->getEntityManager($this->getClass())->getUnitOfWork()->getOriginalEntityData($contract);
  	
  	if($original->isContractSigned == false && $contract->getIsContractSigned() == true) {
  		$contract->setStatus($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('PHRentalsMainBundle:ContractStatus')->find('9'));
  	}  	
  	
  }
  
  public function prePersist($contract)
  {
  	$user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
  	$contract->setCreatedByUser($user);

  	$this->whenUpdating($contract);
  }

  
  public function preUpdate($contract)
  {
  	
  	if($contract->getDateContractSigned() && !$contract->getDateExpiration()) {
  		$date = clone $contract->getDateContractSigned();
  		date_add($date, date_interval_create_from_date_string('1 year'));
  		$contract->setDateExpiration($date);
  	}
  	
  	$this->whenUpdating($contract);
  }
  
  public function getTemplate($name)
  {
  	switch ($name) {
  		case 'edit':
  			return 'PHRentalsMainBundle:Admin:contract-edit.html.twig';
  			break;
  		default:
  			return parent::getTemplate($name);
  			break;
  	}
  	
  }
}