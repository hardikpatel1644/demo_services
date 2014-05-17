<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ixoil\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator;
use FOS\UserBundle\Util\Canonicalizer;
use Ixoil\UserBundle\Entity\User;
use Ixoil\UserBundle\Entity\Account;

/**
 * Helpper method for User managment.
 *
 * @author OXIND
 */
class UserManager
{
    /**
     *
     * @var Symfony\Component\Validator\Validator 
     */
    protected $validator;
    
    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    protected $em;
    
    /**
     *
     * @var FOS\UserBundle\Util\Canonicalizer 
     */
    protected $canonicalizer;

    public function __construct(EntityManager $em, Canonicalizer $canonicalizer, Validator $validator)
    {
        $this->em = $em;
        $this->canonicalizer = $canonicalizer;
        $this->validator = $validator;
    }
    
    /**
     * return false if email already registered.
     * @param string $email
     * @return boolean
     */
    public function isEmailAvailable($email)
    {
        $user = $this->getRepository()->findOneByEmail($email);   
        return (!$user);
    }
    
    /**
     * wraper to validator service.
     * @param object $object
     * @return type
     */
    public function validate($object)
    {
        return $errors = $this->validator->validate($object);
    }
    
    /**
     * populate user entity
     * @param \Ixoil\UserBundle\Entity\User $user
     * @return string
     */
    public function populateUser(User $user)
    {
        $email = $user->getEmail();
        $canonicalEmail = $this->canonicalizer->canonicalize($email);
        
        $user->setUsername($email);
        $user->setUsernameCanonical($canonicalEmail);
        if (!$user->getPassword())
           $user->setPassword($this->utilService->generatePassword(8,1,1,1));
        $user->setPlainPassword($user->getPassword());
        $user->setIsOwner(false);
        $user->setRoles(array('ROLE_USER'));
        $user->setEmailCanonical($canonicalEmail);
    }
    
    /**
     * create subuser of given company account.
     * @param \Ixoil\UserBundle\Entity\User $user
     * @param \Ixoil\UserBundle\Entity\Account $companyAccount
     * @return boolean true if created successfully.
     */
    public function createSubUser(User $user, Account $companyAccount)
    {
        $this->populateUser($user);
        $user->setAccount($companyAccount);
        
        // Validate User object.
        $errors = $this->validate($user);
        if (count($errors))
            return false;
            
        // Add user to database.
        $this->em->persist($user);
        $this->em->flush();
            
        return true;
    }
    
    /**
     * edit subuser of given company account.
     * @param \Ixoil\UserBundle\Entity\User $user
     * @return boolean true if edited successfully.
     */
    public function editSubUser(User $user)
    {
        // Validate User object.
        $errors = $this->validate($user);
        if (count($errors))
            return false;
        
        //set username as email
        $user->setUsername($user->getEmail());
        
        // Update user to database.
        $this->em->persist($user);
        $this->em->flush();
        
        return true;
    }
    

    /**
     * update subuser password .
     * @param \Ixoil\UserBundle\Entity\User $user
     * @return boolean true if password updated successfully.
     */
    public function updatePassword(User $user)
    {
        // Validate User object.
        $errors = $this->validate($user);
        if (count($errors))
            return false;
        
        //set encrypted password
        $user->setPlainPassword($user->getPassword());
        
        // Update user to database.
        $this->em->persist($user);
        $this->em->flush();
        
        return false;
    }
    
    /**
     * @return \Ixoil\UserBundle\Repository\UserRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('IxoilUserBundle:User');
    }
}