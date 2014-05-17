<?php

namespace Ixoil\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of EmailAvailable
 * @Annotation  
 * @author OXIND
 */
class EmailAvailable extends Constraint
{
    /**
     * Error message
     */
    public $message = 'emailevailable.already.in.use';
    
    /**
     * Returns validator alias
     * @return string
     */
    public function validatedBy()
    {
        return 'ixoil_user.emailavailable';
    }
}
