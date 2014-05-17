<?php

namespace Ixoil\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ixoil\CoreBundle\Controller\Controller;
use Ixoil\UserBundle\Form\Type\SubuserType;
use Ixoil\UserBundle\Form\Type\EditSubuserType;
use Ixoil\UserBundle\Form\Type\UpdatePasswordType;
use Ixoil\UserBundle\Entity\User;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * handle subuser related requests.
 *
 * @author OXIND
 * @Route("/users")
 * @PreAuthorize("isAuthenticated()")
 */
class SubUserController extends Controller
{
    /**
     * create subuser
     * @Route("/create" , name="ixoil_user_subuser_create")
     */
    public function createAction()
    {
        // Set breadcrumb
        $this
            ->addBreadcrumb('restricted.dashboard', 'ixoil_dashboard')
            ->addBreadcrumb('restricted.users.list', 'ixoil_user_subuser_list')
            ->addBreadcrumb('restricted.users.create')
        ;
        
        
        $userManager = $this->get('ixoil_user.manager.user');
        
        $logedInUser = $this->getUser();
        
        // Form Handling
        $user = new User();
        $form = $this->createForm(new SubuserType(), $user);
        $request = $this->get('request');
        $form->handleRequest($request);
        
        $isEmailAvailable = true;

        if ($form->isValid()) {
            // Check email already registered or not.
            $email = $user->getEmail();
            $isEmailAvailable = $userManager->isEmailAvailable($email);

            if ($isEmailAvailable) {
                // create sub user.
                $createSuccess = $userManager->createSubUser($user , $logedInUser->getAccount());
                
                if ($createSuccess) {
                    return $this->redirectTo(
                        'ixoil_user_subuser_list', 
                        array('success' => $this->trans('flash_message.user_create', array(), 'subuser'))
                    );
                }
            }
        }
        
        return $this->render(
            'IxoilUserBundle:Subuser:form.html.twig',
            array(
                'form' => $form->createView(), 
                'email_available' => $isEmailAvailable, 
                'title' => 'title.create'
            )
        );
    }
    
    /**
     * to Update/Edit subuser
     * @param integer $id
     * @Route("/edit/{id}" , name="ixoil_user_subuser_edit")
     */
    public function editAction($id)
    {
        // Set breadcrumb
        $this
            ->addBreadcrumb('restricted.dashboard', 'ixoil_dashboard')
            ->addBreadcrumb('restricted.users.list', 'ixoil_user_subuser_list')
            ->addBreadcrumb('restricted.users.edit')
        ;
        
        /* @var $userManager \Ixoil\UserBundle\Manager\UserManager */
        $userManager = $this->get('ixoil_user.manager.user');
        
        $accountId = $this->getUser()->getAccount()->getId();
        $user = $userManager->getRepository()->getSubuser( $id , $accountId);
        
        // when user not exists, return on user lists with error message
        if (!$user) {
            return $this->redirectTo(
                'ixoil_user_subuser_list', 
                array('danger' => $this->trans('core.messages.error.usernot_exists', array(), 'core'))
            );
        }
        
        // Set subtitle
        $this->setSubTitle($user->getEmail());

        // Save old user email
        $userExistEmail = $user->getEmail();
        
        // Handle form
        $isEmailAvailable = true;
        $request = $this->get('request');
        $form = $this->createForm(new EditSubuserType(), $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $user->getEmail();
            $isEmailAvailable = $userManager->isEmailAvailable($email);

            // if email available OR same email as previous
            if ($isEmailAvailable || $email == $userExistEmail) {
                // update user into database
                $editSuccess = $userManager->editSubUser($user);
                if ($editSuccess) {
                    return $this->redirectTo(
                        'ixoil_user_subuser_list', 
                        array('success', $this->trans('flash_message.user_edit', array(), 'subuser'))
                    );
                }
            }
        }

        // render responce content in twig
        return $this->render(
            'IxoilUserBundle:Subuser:form.html.twig',
            array(
                'form' => $form->createView(),
                'email_available' => $isEmailAvailable,
                'title' => 'title.edit'
            )
        );
    }
    
    /**
     * to delete Subuser
     * @param integer $id
     * @Route("/delete/{id}" , name="ixoil_user_subuser_delete")     
     */
    public function deleteAction($id)
    {
        /* @var $userManager \Ixoil\UserBundle\Manager\UserManager */
        $userManager = $this->get('ixoil_user.manager.user');

        // Find user id from query.
        $accountId = $this->getUser()->getAccount()->getId();
        $user = $userManager->getRepository()->getSubuser( $id , $accountId);
        
        // Delete user.
        if ($user) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            return $this->redirectTo(
                'ixoil_user_subuser_list', 
                array('success' => $this->trans('flash_message.user_delete', array(), 'subuser'))
           );
        }
        
        // when user not exists, return on user lists with error message
        return $this->redirectTo(
            'ixoil_user_subuser_list', 
            array('danger' => $this->trans('core.messages.error.usernot_exists', array(), 'core'))
        );
    }
    
    /**
     * to update Password for Subuser
     * @param integer $id
     * @Route("/updatepassword/{id}" , name="ixoil_user_subuser_updatepassword")
     */
    public function updatePasswordAction($id)
    {
        // Set breadcrumb
        $this
            ->addBreadcrumb('restricted.dashboard', 'ixoil_dashboard')
            ->addBreadcrumb('restricted.users.list', 'ixoil_user_subuser_list')
            ->addBreadcrumb('restricted.users.edit', 'ixoil_user_subuser_edit', array('id' => $id))
            ->addBreadcrumb('restricted.users.password')
        ;
        
        /* @var $userManager \Ixoil\UserBundle\Manager\UserManager */
        $userManager = $this->get('ixoil_user.manager.user');
        $accountId = $this->getUser()->getAccount()->getId();
        $user = $userManager->getRepository()->getSubuser( $id , $accountId);

        if ($user) {
            // Set subtitle
            $this->setSubTitle($user->getEmail());
        
            // create form to update password for subuser
            $form = $this->createForm(new UpdatePasswordType(), $user);
            $request = $this->get('request');
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                // update user into database
                $updatePasswordSuccess = $userManager->updatePassword($user);
                if ($updatePasswordSuccess) {
                    return $this->redirectTo(
                        'ixoil_user_subuser_list', 
                        array('success' => $this->trans('flash_message.user_updatepassword', array(), 'subuser'))
                    );
                }
            }

            // render responce content in twig
            return $this->render(
                'IxoilUserBundle:Subuser:form.html.twig',
                array(
                    'form' => $form->createView(), 
                    'title' => 'title.update_password'
                )
            );
        }
        
        // when user not exists, return on user lists with error message
        return $this->redirectTo(
            'ixoil_user_subuser_list', 
            array('danger' => $this->trans('core.messages.error.usernot_exists', array(), 'core'))
        );
    }
    
    /**
     * set datatable configs
     * 
     * @return \Ali\DatatableBundle\Util\Datatable
     */
    private function _datatable()
    {
        $logedInUser = $this->getUser();
        $accountId = $logedInUser->getAccount()->getId();
        
        // Translate lables 
        $firstName = $this->trans('subuser.firstname', array(), 'subuser');
        $lastName = $this->trans('subuser.lastname', array(), 'subuser');
        $email = $this->trans('subuser.email', array(), 'subuser');
        $enabled = $this->trans('subuser.enabled', array(), 'subuser');
        
        $controller_instance = $this;
        // Datatable settings.
        return $this->get('datatable')
            ->setDatatableId('subuser_datatable')
            ->setEntity("IxoilUserBundle:User", "u")
            ->setFields(
                array(
                    $firstName => 'u.firstname',
                    $lastName => 'u.lastname', 
                    $email => 'u.email',
                    $enabled => 'u.enabled',

                    '_identifier_' => 'u.id'
                )
            )
            ->addJoin('u.account', 'a', \Doctrine\ORM\Query\Expr\Join::INNER_JOIN)
            ->setWhere(
                'u.is_owner = :ownership AND a.id = :accountid ',
                array('ownership' => 0, 'accountid'=> $accountId )
            )
            ->setOrder("u.firstname",'asc')
            ->setRenderer(
                function(&$data) use ($controller_instance)
                {
                    $data[3] = $controller_instance
                        ->get('templating')
                        ->render('IxoilUserBundle:Subuser:_enabled.html.twig', array('enabled' => $data[3]));
                }
            )
            ->setRenderers(
                array(
                    4 => array(
                        'view' => 'IxoilUserBundle:Subuser:_datatables_action.html.twig',
                        'params' => array(
                            'edit_route'    => 'ixoil_user_subuser_edit',
                            'delete_route'  => 'ixoil_user_subuser_delete',
                            'update_password_route' => 'ixoil_user_subuser_updatepassword'
                        ),
                    ),
                )
            )    
            ->setHasAction(true)
            ->setSearch(true)
            ->setSearchFields(array(0,1,2))
            ;
    }


    /**
     * @Route("/grid", name="ixoil_user_subuser_grid")
     */
    public function gridAction()
    {
        return $this->_datatable()->execute();// call the "execute" method in your grid action
    }

    
    /**
     * @Route("/list" , name="ixoil_user_subuser_list")
     */
    public function listAction()
    {
        // Set breadcrumb
        $this
            ->addBreadcrumb('restricted.dashboard', 'ixoil_dashboard')
            ->addBreadcrumb('restricted.users.list')
        ;
        
        // Prepare datable
        $this->_datatable();
        
        return $this->render('IxoilUserBundle:Subuser:list.html.twig');
    }
    
}