<?php

namespace Ixoil\UserBundle\Controller;

use Ixoil\AdminBundle\Controller\CRUDController;
use Ixoil\EmailBundle\Model\EmailType;

/**
 * Custom Action handler.
 *
 * @author OXIND
 */
class AccountAdminController extends CRUDController
{
    /**
     * Handle Request for file to download.
     * @param integer $accountid
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function downloadAction($accountid,$filename)
    {
        /* @var $adminManager \Ixoil\AdminBundle\Helper\AccountAdminHelper */
        $adminManager = $this->get('ixoil_user.helper.account.admin');
        
        return $adminManager->getFileAsResponse($accountid, $filename, true);
    }
    
    /**
     * Handle Request for file view.
     * @param integer $accountid
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewFileAction($accountid,$filename)
    {
        /* @var $adminManager \Ixoil\AdminBundle\Helper\AccountAdminHelper */
        $adminManager = $this->get('ixoil_user.helper.account.admin');
        
        return $adminManager->getFileAsResponse($accountid, $filename);
    }
    
    /**
     * Activate company account for trial period.
     * @param integer $accountid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activateTrialAction($accountid)
    {
        $adminManager = $this->get('ixoil_user.helper.account.admin');
        
        // Activate Trial.
        $adminManager->activateTrialOfAccount($accountid);

        return $this->redirectTo(
            'admin_ixoil_core_account_list',
            array('success' => $this->trans('flash_message.trial_activate', array(), 'admin'))
        );
    }

    /**
     * Handle Account Rejection and send a mail notification to company owner.
     * @TODO: Refactor accept/reject system
     * @param integer $accountid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rejectAccountAction($accountid)
    {
        // Get reason of rejection.
        $request = $this->get('request');
        $rejectionReasons = $request->request->get('reason');
        $rejectionReason2 = $request->request->get('reason2');
        
        $invalidFields = null;
        
        if ($rejectionReason2 !== null)
            $invalidFields = $request->request->get('invalid_fields');
        
        // Prepare Email HTML
        $adminManager = $this->get('ixoil_user.helper.account.admin');
        $adminManager->rejectAccount($accountid, $emailHTML);
        
        // Get Owner Details.
        $ownerDetails = $adminManager->getCompanyOwnerDetails($accountid);
        $ownerEmail = $ownerDetails->getEmail();
        
        // Prepare Mailing parameters.
        $arrMailParams = array(
            'name' => $ownerDetails->getFirstname() ,
            'reasons' => $rejectionReasons
        );
        
        if ($rejectionReason2 !== null) {
            $arrMailParams['reason2'] = $rejectionReason2;
            $arrMailParams['invalid_fields'] = $invalidFields;
        }
        
        // Send Account rejected notification mail. 
        $adminManager->sendTwigEmail($ownerEmail, EmailType::AccountReject, $arrMailParams);
        
        return $this->redirectTo(
            'admin_ixoil_core_account_list',
            array('success' => $this->trans('flash_message.account_rejected', array(), 'admin'))
        );
    }
}
