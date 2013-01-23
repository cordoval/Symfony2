<?php
namespace PHRentals\MainBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ReservedAlready extends Constraint
{
    public $message = 'There is already a reservation on this unit at these dates.';
    public function validatedBy()
    {
    	return 'reserved_already_validator';
    }
    
    public function getTargets() {
    	return self::CLASS_CONSTRAINT;
    }
}