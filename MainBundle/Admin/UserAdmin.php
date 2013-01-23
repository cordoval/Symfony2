<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHRentals\MainBundle\Admin;

use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class UserAdmin extends BaseUserAdmin
{
    protected $baseRoutePattern = "/users";
	
	protected $userManager;

	public function getUserManager()
	{
		if (!$this->userManager) {
			$this->userManager = $this->configurationPool->getContainer()->get('fos_user.user_manager');
		}
		return $this->userManager;
	}
	
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('username')
                ->add('email')
                ->add('plainPassword', 'text', array('required' => false))
            ->end()
            ->with('Groups')
                ->add('groups', 'sonata_type_model', array('required' => false, 'expanded' => true, 'multiple' => true))
            ->end()
        ;

        if (!$this->getSubject()->hasRole('ROLE_SUPER_ADMIN')) {
            $formMapper->with('Management')
                ->add('roles', 'sonata_security_roles', array( 'multiple' => true))
                ->add('locked', null, array('required' => false))
                ->add('enabled', null, array('required' => false))
            ->end();
        }

    }
    
    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

}
