<?php
namespace PHRentals\MainBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class UnitSameAdminController extends Controller
{
    
    public function calendarAction() {
    	
    	$id = $this->get('request')->get($this->admin->getIdParameter());
    	
    	$unitSame = $this->admin->getObject($id);
    	
    	if (!$unitSame) {
    		throw new NotFoundHttpException(sprintf('unable to find the unit with id : %s', $id));
    	}
    	
    	if (false === $this->admin->isGranted('VIEW', $unitSame)) {
    		throw new AccessDeniedException();
    	}
    	
    	$this->admin->setSubject($unitSame);
    	
		// Calendar Code Start
    	
    	$helper = $this->container->get('phrentals.helper.calendar');
    	
    	$dates = $helper->createDatesForCalendar($this->get('request')->query->get('form'));

    	// Form to modify the dates
    	
    	$defaultData = array('from' => $dates['from'], 'to' => $dates['to']);
    	$form = $this->createFormBuilder($defaultData, array('csrf_protection' => false))
    	->add('from', 'date', array('attr' => array('name' => 'from'),'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker', 'name' => 'from')))
    	->add('to', 'date', array('attr' => array('name' => 'to'),'widget' => 'single_text', 'attr' => array('class' => 'phrentals_date_picker', 'name' => 'to')))
    	->getForm();
    	
    	$stays = $helper->createStays($unitSame->getUnits(), $dates['from'], $dates['to']);
    	
    	// Calendar Code End
    	
    	return $this->render('PHRentalsMainBundle:Admin:calendar.html.twig', array(
    			'action'   => 'calendar',
    			'object'   => $unitSame,
    			'stays' => $stays,
    			'dates' => $dates,
    			'elements' => $this->admin->getShow(),
    			'form' => $form->createView()
    	));
    
    }
}
?>

