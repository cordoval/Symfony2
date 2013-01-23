<?php
namespace PHRentals\MainBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class AddressAdminController extends Controller
{
	
	public function listAction()
	{
		if (false === $this->admin->isGranted('LIST')) {
			throw new AccessDeniedException();
		}
	
		$datagrid = $this->admin->getDatagrid();
		$pager = $datagrid->getPager();
		$pager->setMaxPerPage(25);
		$formView = $datagrid->getForm()->createView();
	
		// set the theme for the current Admin Form
		$this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
	
		return $this->render($this->admin->getTemplate('list'), array(
				'action'   => 'list',
				'form'     => $formView,
				'datagrid' => $datagrid
		));
	}
    
    public function calendarAction() {
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$address = $this->admin->getObject($id);
    	
    	if (!$address) {
    		throw new NotFoundHttpException(sprintf('unable to find the address with id : %s', $id));
    	}
    	
    	if (false === $this->admin->isGranted('VIEW', $address)) {
    		throw new AccessDeniedException();
    	}
    	
    	$this->admin->setSubject($address);
    	 	
    	// Calendar Code Start
    	 
    	$helper = $this->container->get('phrentals.helper.calendar');
    	 
    	$dates = $helper->createDatesForCalendar($this->get('request')->query->get('form'));
    	
    	// Form to modify the dates
    	 
    	$defaultData = array('from' => $dates['from'], 'to' => $dates['to']);
    	$form = $this->createFormBuilder($defaultData, array('csrf_protection' => false))
    	->add('from', 'date', array('attr' => array('name' => 'from'),'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker', 'name' => 'from')))
    	->add('to', 'date', array('attr' => array('name' => 'to'),'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker', 'name' => 'to')))
    	->getForm();
    	 
    	$stays = $helper->createStays($address->getUnits(), $dates['from'], $dates['to']);
    	 
    	// Calendar Code End
    	
    	return $this->render('PHRentalsMainBundle:Admin:calendar.html.twig', array(
    			'action'   => 'calendar',
    			'object'   => $address,
    			'stays' => $stays,
    			'dates' => $dates,
    			'elements' => $this->admin->getShow(),
    			'form' => $form->createView()
    	));
    
    }
    
    
    public function batchActionMerge() {
    	 
    	$em = $this->container->get('doctrine')->getEntityManager();
    	 
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	 
    	$targetId = $this->get('request')->request->get('targetId');
    	 
    	print($targetId."<br>");
    	 
    	$idx = $this->get('request')->request->get('idx');
    	 
    	// remove targetID from idx
    	foreach($idx as $key => $value) {
    		if($targetId == $value)
    			unset($idx[$key]);
    	}
    	 
    	 
    	print_r($idx);
    	 
    	//exit;
    	 
    	$address = $this->admin->getObject($targetId);
    	 
    	if (!$address) {
    		throw new NotFoundHttpException(sprintf('unable to find the address with id : %s', $id));
    	}
    	 
    	if (false === $this->admin->isGranted('EDIT', $address)) {
    		throw new AccessDeniedException();
    	}
    	 
    	$this->admin->setSubject($address);
    	 
    	// MERGE
    	 
    	$target = $em->getRepository('PHRentalsMainBundle:Address')->find($targetId);
    	 
    	$log = "Target : ". $target->getName().' - ';
    	$i = 0;
    	 
    	foreach($idx as $key => $value) {
    
    		$source = $em->getRepository('PHRentalsMainBundle:Address')->find($value);
    
    		$i++;
    
    		$log .= "Source ".$i." : ". $source->getName().' - ';
    
    		// old ref
    		if($source->getText() != '') {

    			$target->setText($target->getText()." + ".$source->getText());

    			$log .= 'Added address '.$source->getText().' - ';
    		}
    		
    		foreach($source->getUnits() as $property) {
    			
    			print("ICI:".$property->getName()."/".$property->getAddress()-getId()."<br/>");
    			
    			$property->setAddress($target);
    			$source->removeUnit($property);
    			$target->addUnit($property);
    			
    			print("ICI:".$property->getName()."/".$property->getAddress()-getId()."<br/>");

    		}
    		
    		print($log);

       
    		$em->persist($target);
    		$em->remove($source);
    		$em->flush();
    	}
    	 
    	//$em->persist($target);
    	//$em->flush();
    
    	// SEND BACK TO EDIT MODE OF DESTINATION CONTACT
    	 
    	$this->get('session')->setFlash('sonata_flash_success', sprintf('Merge results : %s', $log));
    
    	return $this->redirect($this->admin->generateUrl('edit', array('id' => $targetId)));
    	 
    
    }
    
}
?>

