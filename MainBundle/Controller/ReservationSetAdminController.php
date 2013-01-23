<?php
namespace PHRentals\MainBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class ReservationSetAdminController extends Controller
{
	
	public function showAction($id = null)
	{
		$id = $this->get('request')->get($this->admin->getIdParameter());
	
		$object = $this->admin->getObject($id);
	
		if (!$object) {
			throw new NotFoundHttpException(sprintf('unable to find the reservation with id : %s', $id));
		}
	
		if (false === $this->admin->isGranted('VIEW', $object)) {
			throw new AccessDeniedException();
		}
	
		$this->admin->setSubject($object);
	
		return $this->render('PHRentalsMainBundle:Admin:reservation_show.html.twig', array(
				'action'   => 'show',
				'object'   => $object,
				'elements' => $this->admin->getShow(),
		));
	}

}
?>

