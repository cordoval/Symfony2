<?php

namespace PHRentals\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHRentals\MainBundle\Entity\Outside;
use PHRentals\MainBundle\Form\OutsideType;

/**
 * Outside controller.
 *
 * @Route("/outside")
 */
class OutsideController extends Controller
{
    /**
     * Displays a form to edit an existing Outside entity.
     *
     * @Route("/{link}/edit", name="outside_edit")
     * @Route("/{link}/{val}/validate", name="outside_validate")
     * @Template()
     */
    public function editAction($link, $val = 0)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PHRentalsMainBundle:Outside')->findOneBy(array('link' => $link));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Outside entity.');
        }

        $editForm = $this->createForm(new OutsideType(), $entity);
        
        $text = "";
        
        if($entity->getUnit()) {
        	$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Property Online Listing Form - Update Listing Text');
        }
        else {
        	$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Property Online Listing Form - Create Listing Text');
        }
        if(substr($entity->getStatus(),0,1) == '3') {
        	if($entity->getToDelete()) {
        		$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Property Online Listing Form - Delete Submit Text');
        	} else {
        		$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Property Online Listing Form - Submit Text');
        	}	
        }


        $text = str_replace("[owner-name]", $entity->getContact()->getName(), $text, $count);
        if($entity->getUnit()) {
        	$text = str_replace("[unit]", $entity->getUnit()->getNum(), $text, $count);
        	$text = str_replace("[unit-ref]", $entity->getUnit()->getPRef(), $text, $count);
        	$text = str_replace("[contract-ref]", $entity->getContract()->getKRef(), $text, $count);
        	$text = str_replace("[delete-link]", $this->generateUrl('outside_delete', array('link' => $entity->getLink())), $text, $count);
        } else {
        	$text = str_replace("[unit]", $entity->getNum(), $text, $count);
        	$text = str_replace("[unit-ref]", "", $text, $count);
        	$text = str_replace("[contract-ref]", "", $text, $count);
        	$text = str_replace("[delete-link]", "", $text, $count);
        }
        $text = str_replace("[add-link]", $this->generateUrl('outside_add', array('link' => $entity->getLink())), $text, $count);
        if($entity->getProject()) {
        	$text = str_replace("[project]", $entity->getProject()->getName(), $text, $count);
        } else {
        	$text = str_replace("[project]", $entity->getDistrict(), $text, $count);
        }
        
        // images
        $images = null;
        if ($entity->getUnit()) {
        	$images = $entity->getUnit()->getImages();
        }
        
        // new uploaded images
        $newimages = null;
        $targetFolder = '../uploaded_file/listingform/'.$entity->getId().'/';
         
        if(is_dir($targetFolder)) {
        
        	$newimages = scandir($targetFolder);
        	foreach ($newimages as $key => $file) {
        		if ($file === '.' || $file === '..' || substr(strrchr($file, '.'), 1) != 'jpg') {
        			unset($newimages[$key]);
        		}
        	}
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        	'text'	=> $text,
        	'val' => $val,
        	'timestamp' => time(),
        	'token' => md5('unique_salt' . time()),
        	'images' => $images,
        	'newimages' => $newimages
        );
    }
    

    /**
     * Edits an existing Outside entity.
     *
     * @Route("/{link}/update", name="outside_update")
     * @Route("/{link}/{val}/update", name="outside_update2")
     * @Method("POST")
     * @Template("PHRentalsMainBundle:Outside:edit.html.twig")
     */
    public function updateAction(Request $request, $link, $val = 0)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PHRentalsMainBundle:Outside')->findOneBy(array('link' => $link));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Outside entity.');
        }

        $editForm = $this->createForm(new OutsideType(), $entity);
        $editForm->bind($request);
        
        if ($editForm->isValid()) {
        	if ($val == 0) {
        		$entity->setStatus('2/4 - owner updated listing');
        	} else {
        		$entity->setStatus('2/4 - staff updated listing');
        	}
        	$this->get('session')->setFlash('notice', 'Listing saved!');
        	$entity->setUpdatedOn(new \DateTime('now'));
            $em->persist($entity);
            $em->flush();
            if ($val == 0) {
            	return $this->redirect($this->generateUrl('outside_edit', array('link' => $link)));
            } else {
            	return $this->redirect($this->generateUrl('outside_validate', array('link' => $link, 'val' => $val)));
            }
            
            
        } elseif($results = $request->get('form')) {
        	
        	$entity->setStatus('3/4 - owner wants to delete listing');
        	$entity->setToDelete($results['toDelete']);
        	$entity->setToDeleteText($results['toDeleteText']);
        	$em->persist($entity);
        	$em->flush();
        	$this->get('session')->setFlash('notice', 'Listing marked as deleted!');
        	return $this->redirect($this->generateUrl('outside_edit', array('link' => $link)));
        }
        
        //$this->get('session')->setFlash('notice', $editForm->getErrorsAsString());
    }
    
    /**
     * Edits an existing Outside entity.
     *
     * @Route("/{link}/submit", name="outside_submit")
     * @Route("/{link}/{val}/submit", name="outside_submit2")
     * @Method("POST")
     * @Template("PHRentalsMainBundle:Outside:edit.html.twig")
     */
    public function submitAction(Request $request, $link, $val = 0)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('PHRentalsMainBundle:Outside')->findOneBy(array('link' => $link));
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Outside entity.');
    	}
    
    	$editForm = $this->createForm(new OutsideType(), $entity);
    	$editForm->bind($request);
    
    	if ($editForm->isValid()) {
    
    		if ($val == 0) {
    			$entity->setStatus('3/4 - owner submitted listing');
    			$entity->setUpdatedOn(new \DateTime('now'));
    			$em->persist($entity);
    			$em->flush();
    			$this->get('session')->setFlash('notice', 'Listing submitted!');
    			return $this->redirect($this->generateUrl('outside_edit', array('link' => $link)));
    		} else {
    			$em->persist($entity);
    			$em->flush();
    			$this->get('session')->setFlash('notice', 'Listing saved by staff!');
    			return $this->redirect($this->generateUrl('outside_validate', array('link' => $link, 'val' => $val)));
    		}
    	}
    	
    	//$this->get('session')->setFlash('notice', 'Listing submitted!');
    
    	return array(
    			'entity'      => $entity,
    			'edit_form'   => $editForm->createView()
    	);
    }
    
    /**
     * Displays a form if an Owner wants to delete an existing Listing
     *
     * @Route("/{link}/delete", name="outside_delete")
     * @Template("PHRentalsMainBundle:Outside:delete.html.twig")
     */
    public function deleteAction($link)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('PHRentalsMainBundle:Outside')->findOneBy(array('link' => $link));
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Outside entity.');
    	}
    	if ($this->get('request')->getMethod() == 'POST') {
    		$results = $this->get('request')->get('form');
    		$entity->setStatus('3/4 - owner wants to delete listing');
    		$entity->setToDelete($results['toDelete']);
    		$entity->setToDeleteText($results['toDeleteText']);
    		$em->persist($entity);
    		$em->flush();
    		$this->get('session')->setFlash('notice', 'Listing marked as deleted!');
    		return $this->redirect($this->generateUrl('outside_edit', array('link' => $link)));
    	}
    
    	//$editForm = $this->createForm(new OutsideType(), $entity);
    	//$deleteForm = $this->createDeleteForm($id);
    	
    	$deleteForm = $this->createFormBuilder(null, array('csrf_protection' => false))
            ->add('toDelete', 'choice', array('required' => true, 'choices' => array(
    			'Sold or unavailable for extended period' => 'Sold or unavailable for extended period',
				'Halt listing process and contact me' => 'Halt listing process and contact me',
				'Halt and remove this listing permanently' => 'Halt and remove this listing permanently',
				'Cancel my existing Agency Agreement for all my listings' => 'Cancel my existing Agency Agreement for all my listings'
    	)))
            ->add('toDeleteText', 'textarea')
    	->getForm();
    
    	$text = array();
    	$text['delete'] = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Property Online Listing Form - Delete Listing Text');

    	$text['delete'] = str_replace("[owner-name]", $entity->getContact()->getName(), $text['delete'], $count);
    	$text['delete'] = str_replace("[unit]", $entity->getUnit()->getNum(), $text['delete'], $count);
    	$text['delete'] = str_replace("[unit-ref]", $entity->getUnit()->getPRef(), $text['delete'], $count);
    	$text['delete'] = str_replace("[contract-ref]", $entity->getContract()->getKRef(), $text['delete'], $count);
    	$text['delete'] = str_replace("[project]", $entity->getProject()->getName(), $text['delete'], $count);
    
    	return array(
    			'entity'      => $entity,
    			'edit_form'   => $deleteForm->createView(),
    			'text'	=> $text
    	);
    }
    
    /**
     * Displays a form if an Owner wants to add an existing Listing
     *
     * @Route("/{link}/add", name="outside_add")
     * @Template("PHRentalsMainBundle:Outside:add.html.twig")
     */
    public function addAction($link)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('PHRentalsMainBundle:Outside')->findOneBy(array('link' => $link));
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Outside entity.');
    	}
    	
    	$results = $this->get('request')->request->get('form');
    	
    	if ($this->get('request')->getMethod() == 'POST') {
    		
    		$contact = $em->getRepository('PHRentalsMainBundle:Contact')->find($results['contact']);
    	
    		// CREATE AN "OUTSIDE OBJECT" TO CREATE A NEW UNIT
    		 
    		$outside = new Outside();
    		 
    		$outside->setCreatedOn(new \DateTime('now'));
    		//$outside->setCreatedByUser();
    		 
    		$notfound = true;
    		 
    		while ($notfound) {
    			$slug = md5(uniqid(rand(), true));
    			$slug = substr($slug, 0, 9);
    		  
    			$outside_exists = $em->getRepository('PHRentalsMainBundle:Outside')->findOneBy(array('link' => $slug));
    			if (!$outside_exists) {
    				$notfound = false;
    			}
    		}
    		 
    		$outside->setLink($slug);
    		$outside->setStatus('1/4 - listing link created');
    		 
    		 
    		// contact info
    		 
    		if($contact->hasType('Developer') || $contact->hasType('Agency')) {
    			$outside->setOwnerType('Company');
    		}
    		else {
    			$outside->setOwnerType('Private Owner');
    		}
    		 
    		$outside->setContact($contact);
    		$outside->setName($contact->getName());
    		$outside->setWeb($contact->getWeb());
    		if($email = $contact->getEmail()->first()) {
    			$outside->setEmail($email->getEmail());
    		}
    		if($tel = $contact->getTels()->first()) {
    			$outside->setTel($tel->getTel());
    		}
    		if($tel = $contact->getTels()->next()) {
    			$outside->setTel2($tel->getTel());
    		}
    		$outside->setPrefixName($contact->getPrefixName());
    		$outside->setFirstName($contact->getFirstName());
    		$outside->setLastName($contact->getLastName());
    		$outside->setAge($contact->getAge());
    		$outside->setNationality($contact->getNationality());
    		$outside->setAddressHome($contact->getAddressHome());
    		$outside->setAddress($contact->getAddress());
    	
    		$outside->setAgencyFee('5');
    		$outside->setAgencyDepositRate('10');
    		$outside->setDeposit('2 months rent');
    		$outside->setIsOwnerCaretaker(true);
    	
    		$outside->setInspection("Key located at/with:\nName of person who can show unit:\nMobile phone for inspections:\nInspection Notes:");
    		$outside->setTransferFeeBy('50/50 Owner and Buyer');
    		$outside->setConditions("Advance/Booking fee for 'Holiday Rental' ___% the of total price.\nHoliday rentals are accepted ___ months in advance");
    		$outside->setUtilities("Electric: _______ Baht / unit\nWater: _______ Baht / unit\nWi-Fi: _______ Baht / (month) / (week) / (day)\nOther charges: _____________");
    	
    	
    		$outside->setClass($em->getRepository('PHRentalsMainBundle:UnitClass')->find($results['unitClass']));
    	
    			$project = $em->getRepository('PHRentalsMainBundle:Project')->find($results['projects']);
    			$address = $project->getAddress();
    			 
    			$outside->setProject($project);
    	
    			// address
    			$outside->setAddressUnit($address->getText());
    			$outside->setDistrict($address->getDistrict());
    			$outside->setDistanceToBeach($address->getDistanceToBeach());
    			foreach($address->getTags() as $tag) {
    				$outside->addAddressTag($tag);
    			}
    		 
    		$em->persist($outside);
    		$em->flush();
    		 
    		//print_r(new Outside());
    		//exit;
    	
    		// SEND BACK TO EDIT MODE OF DESTINATION CONTACT
    		$this->get('session')->setFlash('sonata_flash_success', 'Property Online Listing Form created.');
    		 
    		return $this->redirect($this->generateUrl('outside_edit', array('link' => $outside->getLink())));
    		//return $this->redirect($this->generateUrl('admin_phrentals_main_contact_edit', array('id' => $contact->getId())));
    	}
    	else
    	{
    
			$unitClasses = array();
		    foreach($em->getRepository('PHRentalsMainBundle:UnitClass')->findAll() as $unitClass) {
		    	$unitClasses[$unitClass->getId()] = $unitClass->getName();
		    }
		    	
		    $projects = array();
		    foreach($em->getRepository('PHRentalsMainBundle:Project')->findBy(array(), array('name' => 'asc')) as $project) {
		    	$projects[$project->getId()] = $project->getName();
		    }
		    
		    // pre-choose address class of previous unit
		    $class = $entity->getClass()->getId();
		    
		    // pre-choose project of previous unit
		    $project = null;
		    if($entity->getProject()) {
		    	$project = $entity->getProject()->getId();
		    }	
		    
		    $addForm = $this->createFormBuilder(array('unitClass' => $class, 'projects' => $project, 'contact' => $entity->getContact()->getId()), array('csrf_protection' => false))
		    	->add('unitClass', 'choice', array('label' => 'Unit Class','choices' => $unitClasses, 'required'  => true))
	    		->add('projects', 'choice', array('label' => 'Project','choices' => $projects, 'required'  => true))
	    		->add('contact', 'hidden')
	    		//->add('standalone', 'checkbox', array('label' => 'Standalone unit?', 'required'  => false))
		    	->getForm();
	    
	    	$text = array();
	    	$text = $em->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('Property Online Listing Form - Owner Add Listing Text');
	    
	    	$text = str_replace("[owner-name]", $entity->getContact()->getName(), $text, $count);
    
	    	return array(
	    			'entity'      => $entity,
	    			'add_form'   => $addForm->createView(),
	    			'text'	=> $text
	    	);
    	}
    }

}
