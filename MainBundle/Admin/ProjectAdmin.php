<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
 
use PHRentals\MainBundle\Entity\Project;

class ProjectAdmin extends Admin
{
    protected $baseRoutePattern = "/projects";
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('name', null, array('required' => true))
      ->add('website')
      ->add('description')
      //->add('completedOn', 'date', array('label' => 'Completed On', 'required' => false, 'widget' => 'single_text', 'format' => 'd/M/y',  'attr' => array('class' => 'phrentals_date_picker')))
      ->add('completedOn', 'genemu_jquerydate', array('widget' => 'single_text', 'format' => 'd/M/y', 'required' => false, 'years' => range(date('Y') - 20, date('Y') + 5)))
      //->add('developer', 'sonata_type_model_list', array('label' => 'Developer', 'required' => false))
      ->add('developer', 'genemu_jqueryautocompleter_entity', array(
      		'label' => 'Developer', 
      		'required' => false,
      		'route_name' => 'ajax_dev',
      		'class' => 'PHRentals\MainBundle\Entity\Contact'
      ))
      ->add('slug', 'genemu_plain' , array('disabled' => true, 'required'=>false))
      ->add('id', 'genemu_plain' , array('disabled' => true, 'required'=>false))
      ->end()
     ->with('Address', array('collapsed' => false))
      ->add('address', 'sonata_type_admin', array('label' => '', 'delete' => false))
      ->end()
     ->with('Website page', array('collapsed' => true))
      ->add('furnished')
      ->add('sinkingFund')
      ->add('maintenanceFee')
      ->add('constructionStarts')
      ->add('expectedCompletion')
      ->add('totalBuildings')
      ->add('totalUnits')
      ->add('totalFloors')
      ->add('reservation')
      ->add('deposit')
      ->add('installments')
      ->add('handover')
      ->add('unitTypeFrom')
      ->add('unitTypeTo')
      ->add('livingAreaFrom')
      ->add('livingAreaTo')
      ->add('priceFrom')
      ->add('priceTo')
      ->add('priceSqmMin')
      ->add('priceSqmMax')
	  ->end()
	->with('Extra', array('collapsed' => true))
	  ->add('launched')
      ->add('constructionStarts')
      ->add('expectedCompletion')
      ->add('buildDuration')
      ->add('projectType')
      ->add('totalBuildings')
      ->add('totalUnits')
      ->add('totalFloors')
      ->add('eiaStatus')
      ->add('sales')
      ->add('directions')
      ->add('configuration')
      ->add('composition')
      ->add('salesPriceGuide')
      ->add('amenities')
      ->add('security')
      ->add('descriptiontext')
      ->add('studioMinSqm')
      ->add('studioMinPrice')
      ->add('studioMaxSqm')
      ->add('studioMaxPrice')
      ->add('bed1minSqm')
      ->add('bed1minPrice')
      ->add('bed1maxSqm')
      ->add('bed1maxPrice')
      ->add('bed2minSqm')
      ->add('bed2minPrice')
      ->add('bed2maxSqm')
      ->add('bed2maxPrice')
      ->add('bed3minSqm')
      ->add('bed3minPrice')
      ->add('bed3maxSqm')
      ->add('bed3maxPrice')
      ->end()
      ;
  }
  
  /**
   * Default Datagrid values
   *
   * @var array
   */
  protected $datagridValues = array(
  		'_page' => 1,
  		'_sort_order' => 'ASC',
  		'_sort_by' => 'name'
  );
  
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('name')
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->add('id', 'string', array('label' => 'ID', 'template' => 'PHRentalsMainBundle:Admin:list-id.html.twig'))
      ->addIdentifier('name')
      ->add('address.class')
      ->add('completedOn', 'string', array('label' => 'Completed On', 'template' => 'PHRentalsMainBundle:Admin:project-completed.html.twig'))
      ->add('units', 'string', array('label' => 'Nb of Units', 'template' => 'PHRentalsMainBundle:Admin:number_of_units.html.twig'))
	  ->add('developer')
      ->add('address.district')
      ->add('Website', 'string', array('label' => 'Website', 'template' => 'PHRentalsMainBundle:Admin:project_list_website.html.twig'))
	  ->add('address.text')
    ;
  }
  
  public function getBatchActions()
  {
  	// retrieve the default (currently only the delete action) actions
  	//$actions = parent::getBatchActions();
  	$actions = null;
  
  	// check user permissions
  	if($this->hasRoute('edit') && $this->isGranted('EDIT') && $this->hasRoute('delete') && $this->isGranted('DELETE')){
  		$actions['merge']=array(
  				'label'            => 'Merge Projects',
  				'ask_confirmation' => true // If true, a confirmation will be asked before performing the action
  		);
  
  	}
    	return $actions;
  }
  
  public function whenUpdating($project)
  {
  	 
  	if(!$project->getSlug()) {
  		$project->setSlug($this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass())->createSlug($project));
  	}
  	 
  	 
  }
  
  public function prePersist($project)
  {
  	$this->whenUpdating($project);
  }
  
  public function preUpdate($project)
  {
  	$this->whenUpdating($project);
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
  
  public function getTemplate($name)
  {
  	switch ($name) {
  		case 'edit':
  			return 'PHRentalsMainBundle:Admin:project-edit.html.twig';
  			break;
  		default:
  			return parent::getTemplate($name);
  			break;
  	}
  }
  
}