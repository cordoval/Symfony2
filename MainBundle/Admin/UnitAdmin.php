<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use PHRentals\MainBundle\Entity\Unit as UnitEntity;
 
class UnitAdmin extends Admin
{
    protected $baseRoutePattern = "/units";
    
    protected function configureRoutes(RouteCollection $collection)
    {
    	$collection->remove('show');
        $collection->add('duplicate', $this->getRouterIdParameter().'/duplicate');
        //$collection->add('calendar', $this->getRouterIdParameter().'/calendar');
        $collection->add('search', 'search');
        $collection->add('createcontract', $this->getRouterIdParameter().'/contract');
        $collection->add('catalogue', $this->getRouterIdParameter().'/catalogue');
        $collection->add('display', $this->getRouterIdParameter().'/display');
        $collection->add('details', $this->getRouterIdParameter().'/details');
        //$collection->add('reservation_show', './reservations/'.$this->getRouterIdParameter().'/show');
        //$collection->add('calendar', '/calendar');
        //<a href="{{ admin.generateUrl('list', params|merge('page': 1) }}">List</a>
        //$collection->add('view', $this->getRouterIdParameter().'/view');
        
        /*
        $collection
        ->add('dummy',
        		'dummy/{id}',
        		array('_controller' => 'AcmeDemoBundle:Default:dummy'),
        		array('id' => '\d+')
        )
        ;
        */
        
    }
    
  protected function configureFormFields(FormMapper $formMapper)
  {
  	
  	$query_class = $this->getModelManager()->getEntityManager('PHRentals\MainBundle\Entity\UnitClass')->createQuery('SELECT s FROM PHRentals\MainBundle\Entity\UnitClass s ORDER BY s.id ASC');
  	
    $formMapper
    ->with('General')
      ->add('num', null, array('required' => false, 'label' => 'Unit #'))
      ->add('pRef', null, array('required' => true))
      ->add('active', null, array('required' => false))
      ->add('webTitle', null, array('required' => false))
      ->add('class', 'sonata_type_model', array('required' => true, 'query' => $query_class), array('edit' => 'standard'))
      ->add('project', 'sonata_type_model_list', array('required' => false))
      //->add('building', null, array('required' => false, 'label' => 'Building #'))
      ->add('address', 'sonata_type_model_list', array('required' => false))
      ->add('owner', 'sonata_type_model_list')
      ->add('ownership', 'choice', array('required' => false, 'choices' => UnitEntity::getOwnershipList()))
    ->end()
    ->with('Description', array('collapsed' => false))
      ->add('description')
      ->add('unitType', null, array('required' => false))
      ->add('floor')
      ->add('livingArea')
      ->add('landSize')
      ->add('bedrooms', 'choice', array('required' => true, 'choices' => array('0','1','2','3','4','5','6','7','8')))
      ->add('bathrooms', 'choice', array('required' => true, 'choices' => array('0','1','2','3','4','5','6','7','8')))
      ->add('sleeps')
      ->add('hasExtraBed')
      ->add('tags', 'sonata_type_model', array('expanded' => true, 'multiple' => true, 'by_reference' => false, 'attr' => array ('class' => 'taglist')))
    ->end()
    ->with('Internal', array('collapsed' => false))
      ->add('rating', null, array('required' => false))
      ->add('remarks', null, array('required' => false))
      //->add('generateThumbnails', null, array('required' => false))
      ->add('featured', null, array('required' => false))
      //->add('incomplete', null, array('required' => false))
      //->add('photos', null, array('required' => false))
      ->add('chanote', null, array('required' => false))
    ->end()
    ->with('Files', array('collapsed' => false))
    ->add('images', 'sonata_type_collection', array('by_reference' => false), array(
    		'edit' => 'inline',
    		'inline' => 'table',
    ))
       
    ->setHelps(array(
      		'name' => $this->trans('Name should be what makes the Unit unique, for eample the unit number in a condo. If no name, leave blank.'),
      		'address' => $this->trans('Only indicate an address if the Unit is not part of a Project or Village.'),
    		'pRef' => $this->trans('Once created pRef should never be modified.'),
    		'rating' => $this->trans('= ([price/sqm] * [district factor] / 60000) + 20% if "featured". Erase to recalculate.')
    		))
      ;
      
      if ($this->getSubject()->getId()) {
      	$formMapper
      	->with('Internal')
      	->add('createdByUser', 'genemu_plain', array('label' => 'Created by', 'disabled' => true, 'data_class' => 'Application\Sonata\UserBundle\Entity\User', 'required'=>false))
      	->add('createdOn', 'genemu_plain', array('date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
      	->add('updatedByUser', 'genemu_plain', array('label' => 'Updated by', 'disabled' => true, 'data_class' => 'Application\Sonata\UserBundle\Entity\User', 'required'=>false))
      	->add('updatedOn', 'genemu_plain', array('label' => 'Updated on', 'date_pattern' => 'd/M/y', 'data_class' => 'DateTime', 'required'=>false))
      	->add('slug', 'genemu_plain' , array('disabled' => true, 'required'=>false))
      	->end()
      	;
      }    
      
  }
  
    protected function configureShowFields(ShowMapper $filter)
  {
  	
  	$filter
  	->add('pRef')
    ->add('num')
    ->add('owner')
    ->add('unitClass')
    ->add('unitSize')
    ->add('address')
    ->add('description')
    ->add('unitNumber')
    ->add('roomNumber')
    ->add('floor')
    ->add('livingArea')
    ->add('landSize')
    ->add('bedrooms')
    ->add('bathrooms')
    ->add('sleeps')
    ->add('hasExtraBed')
    ->add('tags')
    ->add('Reservations', 'string', array('template' => 'PHRentalsMainBundle:Admin:unit_reservations.html.twig'))
    ->add('createdOn')
    ->add('updatedOn')
    ->end();
                
  }
  
  
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('num')
      ->add('pRef')
      ->add('class')
      ->add('webTitle')
      ->add('project')
      ->add('livingArea')
      ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
  	//->addIdentifier('name', null, array('route' => array('name' => 'calendar')))
  	
    $listMapper
      ->add('num', 'string', array('label' => 'Unit', 'template' => 'PHRentalsMainBundle:Admin:unit_list_num.html.twig'))
      ->addIdentifier('pRef')
      ->add('PPB', 'string', array('label' => 'PPB/Address (Class)', 'template' => 'PHRentalsMainBundle:Admin:unit_list-project-or-address.html.twig'))
      ->add('Type', 'string', array('label' => 'Type', 'template' => 'PHRentalsMainBundle:Admin:unit_list_type.html.twig'))
      ->add('owner')
      //->add('contracts')
      ->add('Contract', 'string', array('label' => 'Contract', 'template' => 'PHRentalsMainBundle:Admin:unit_list_contract.html.twig'))
      ->add('Website', 'string', array('label' => 'Website', 'template' => 'PHRentalsMainBundle:Admin:unit_list_website.html.twig'))
      ->add('Folder', 'string', array('label' => 'Folder', 'template' => 'PHRentalsMainBundle:Admin:unit_list_folder.html.twig'))
      //->add('custom', 'string', array('label' => 'High/Peak', 'template' => 'PHRentalsMainBundle:Admin:highseason.html.twig'))
    /*->add('_action', 'actions', array(
        'actions' => array(
            'edit' => array(),
        	'calendar' => array()
        )))*/
    ;
  }
  
  public function whenUpdating($unit)
  {
  	
  	if($unit->getProject()) {
  		$unit->setAddress(null);
  		$address = $unit->getProject()->getAddress();
  	} else {
  		$address = $unit->getAddress();
  	}
  	
  	$rating = 0;
  	
  	if(!$unit->getRating() && ($contract = $unit->getActiveContract())) {
  		
  		if ($contract->getSalePricePerSqm()) {  		
  		$rating = ($contract->getSalePricePerSqm()/60000)*$address->getDistrict()->getFactor();
  		}
  		elseif ($unit->getLivingArea()>0) {
  			$rating = ($contract->getSalePrice()/$unit->getLivingArea()/60000)*$address->getDistrict()->getFactor();
  		}
  		
  		if ($unit->getFeatured()) {
  			$rating = $rating * 120/100;
  		}
  		
  		if(($rating = round($rating,2)) > 0) {
  			$unit->setRating($rating);
  		}
  		
  	}
  	
  	if(!$unit->getSlug()) {
  		$unit->setSlug($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass())->createSlug($unit));
  	}
  	
  	
  }
  
  public function prePersist($unit)
  {
  	$user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
  
  	$unit->setUpdatedByUser($user);
  	$unit->setCreatedByUser($user);
  	$this->whenUpdating($unit);
  	 
  }
  
  public function preUpdate($unit)
  {
  	$user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
  	$unit->setUpdatedByUser($user);
  	$this->whenUpdating($unit);
  
  }
 
  public function validate(ErrorElement $errorElement, $object)
  {
    $errorElement
      ->with('num')
      ->assertMaxLength(array('limit' => 255))
      ->end()
    ;
    
  }
  
  public function getNewInstance()
  {
  	$instance = parent::getNewInstance();
  	
  	$instance->setPRef($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass())->findNextRef());
  	
  	if ($this->getRequest()->getMethod() == 'GET' && $this->getRequest()->get('owner_id')) {
  	$owner_id = $this->getRequest()->get('owner_id');
  	$instance->setOwner($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('PHRentals\MainBundle\Entity\Contact')->find($owner_id));
  	} 
  	return $instance;
  }
  
  public function getTemplate($name)
  {
  	switch ($name) {
  		case 'edit':
  			return 'PHRentalsMainBundle:Admin:unit-edit.html.twig';
  			break;
  		case 'display':
  			return 'PHRentalsMainBundle:Admin:unit-display.html.twig';
  			break;
  		default:
  			return parent::getTemplate($name);
  			break;
  	}
  	
  }

}