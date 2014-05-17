<?php

namespace Ixoil\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Ixoil\UserBundle\Manager\UserManager;

/**
 * Description of EmailAvailable
 *
 * @author OXIND
 */
class EmailAvailableValidator extends ConstraintValidator
{
    /**
     * User manager
     */
    protected $userManager;
    
    /**
     * 
     * @param \Ixoil\UserBundle\Manager\UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }
    
    /**
     * Check if the specified email is available
     * @param type $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $isEmailAvailable = $this->userManager->isEmailAvailable($value);
        
        if (!$isEmailAvailable)
            $this->context->addViolation($constraint->message);
    }
}
