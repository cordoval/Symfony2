<?php

namespace PHRentals\MainBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
 
class DistrictAdmin extends Admin
{
    
    protected $baseRoutePattern = "/districts";

    protected $maxPerPage = 200;
    
    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array(
    		'_page' => 1,
    		'_sort_order' => 'ASC',
    		'_sort_by' => 'location.id'
    );
    
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('name')
      ->add('location', 'sonata_type_model')
      ->add('factor')
      //->add('active', null, array('required' => false))
    ;
  }
 
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('name')
      ->add('location')
    ;
  }
 
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('name')
      ->add('location')
      ->add('factor')
    ;
  }
  
  public function getExportFields()
  {
  	$results = $this->getModelManager()->getExportFields($this->getClass());
  
  	// Need to add again our foreign key field here
  	$results[] = 'location';  
  	 
  	return $results;
  }
  
  public function getExportFormats()
  {
  	return array(
  			'csv', 'xls'
  	);
  }
  
  public function getNewInstance()
  {
  	$instance = parent::getNewInstance();

  	$instance->setFactor('1');
  
  	return $instance;
  }
 
  public function validate(ErrorElement $errorElement, $object)
  {
    $errorElement
      ->with('name')
      ->assertMaxLength(array('limit' => 127))
      ->end()
    ;
  }
}