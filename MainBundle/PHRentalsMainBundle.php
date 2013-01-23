<?php

namespace PHRentals\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PHRentalsMainBundle extends Bundle
{
	
	public function getParent()
	{
		return 'SonataAdminBundle';
	}
	
}
