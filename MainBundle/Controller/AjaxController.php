<?php
namespace PHRentals\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AjaxController extends Controller
{
    /**
     * @Route("/ajax_owner", name="ajax_owner")
     */
    public function ajaxOwnerAction(Request $request)
    {
        $value = $request->get('term');

        $em = $this->getDoctrine()->getEntityManager();
        $owners = $em->getRepository('PHRentalsMainBundle:Contact')->findAjaxValue($value);

        $json = array();
        foreach ($owners as $owner) {
            $json[] = array(
                'label' => $owner->getName(),
                'value' => $owner->getId()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
    
    /**
     * @Route("/ajax_dev", name="ajax_dev")
     */
    public function ajaxOwnerDevAction(Request $request)
    {
    	$value = $request->get('term');
    
    	$em = $this->getDoctrine()->getEntityManager();
    	$owners = $em->getRepository('PHRentalsMainBundle:Contact')->findAjaxDevValue($value);
    
    	$json = array();
    	foreach ($owners as $owner) {
    		$json[] = array(
    				'label' => $owner->getName(),
    				'value' => $owner->getId()
    		);
    	}
    
    	$response = new Response();
    	$response->setContent(json_encode($json));
    
    	return $response;
    }

    /**
     * @Route("/ajax_address", name="ajax_project")
     */
    public function ajaxProjectAction(Request $request)
    {
        $value = $request->get('term');

        $em = $this->getDoctrine()->getEntityManager();
        $addresses = $em->getRepository('PHRentalsMainBundle:Project')->findAjaxValue($value);

        $json = array();
        foreach ($addresses as $address) {
            $json[] = array(
                'label' => $address->getName(),
                'value' => $address->getId()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
    
    /**
     * @Route("/ajax_savenotes", name="ajax_savenotes")
     */
    public function ajaxSaveNotesAction(Request $request)
    {
    	$notes = $request->get('notes');
    	$hash = $request->get('hash');
    
    	$response = new Response();
    	
    	$file = "notes.txt";
    	
    	if ($hash == sha1_file($file)) {
    	
    	$open = fopen($file, 'w');
    	fwrite($open, $notes);
    	fclose($open);
    	$response->setContent("Saved");
    	}
    	else {
    	$response->setContent("Could not save as the file was updated by someone else. Please refresh page.");
    	}
    
    	return $response;
    }
}