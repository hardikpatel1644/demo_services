<?php

namespace Ixoil\UserBundle\Helper;

use Symfony\Component\HttpFoundation\Response;
use Ixoil\FileBundle\Model\FileType;
use Ixoil\UserBundle\Model\SubscriptionType;
use Ixoil\UserBundle\Entity\SubscriptionOptionToAccount;
use Ixoil\UserBundle\Entity\SubscriptionToAccount;
use Ixoil\UserBundle\Entity\Account;
use Ixoil\UserBundle\Model\AccountStatus;
use Ixoil\EmailBundle\Model\EmailType;

/**
 * Helper methods for AccountAdminController.
 *
 * @author bhavin.jagad
 */
class AccountAdminHelper
{
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * @var \Ixoil\FileBundle\Manager\FileManager
     */
    protected $fileManager;
    
    /**
     *
     * @var \Ixoil\EmailBundle\Mailer\TwigMailer
     */
    protected $mailer;

    /**
     *
     * @var \Symfony\Bundle\FrameworkBundle\Translation\Translator 
     */
    protected $translator;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Ixoil\FileBundle\Manager\FileManager $fileManager
     * @param \Ixoil\EmailBundle\Mailer\TwigMailer $mailer
     * @param \Symfony\Bundle\FrameworkBundle\Translation\Translator $translator
     */
    public function __construct($em, $fileManager, $mailer, $translator)
    {
        $this->em = $em;
        $this->fileManager = $fileManager;
        $this->mailer = $mailer;
        $this->translator = $translator;
    }

    /**
     * Method to send email.
     * @param type $to
     * @param string $emailType
     * @param array $arrParams
     * @return bool
     */
    public function sendTwigEmail($to, $emailType, array $arrParams)
    {
        return $this->mailer->sendTwigEmail($to, $emailType, $arrParams);
    }
    
    /**
     * Return file content in a respnse object
     * @param integer $accountid Company Account id
     * @param string $filename Name of the file.
     * @return \Ixoil\AdminBundle\Manager\Response
     *          Response containing File.
     */
    public function getFileAsResponse($accountid, $filename, $download = false)
    {
        // Prepare Account object using $accountid
        /* @var $account \Ixoil\UserBundle\Entity\Account */
        $account = $this->em->getRepository('IxoilUserBundle:Account')->find($accountid);

        // Get file content to send as a response.
        $dirPath = $this->fileManager->getFilePath(FileType::account($account));
        $filePath = $dirPath . $filename;
        
        // Get Mime type to set in response header.
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);
        
        //set headers
        $response = new Response();
        $response->setContent(file_get_contents($filePath));
        $response->headers->set('Content-Type', $mimeType);
        
        // Set donwload header to response
        if ($download)
            $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);
        
        return $response;
    }
    
    /**
     * Return company owener details 
     * @param integer $accountid Company account id.
     * @return \Ixoil\UserBundle\Entity\User
     */
    public function getCompanyOwnerDetails($accountid)
    {
       $repository = $this->em->getRepository('IxoilUserBundle:User');
       $result = $repository->getCompanyOwnerDetails($accountid);
       return  $result;
    }
    
    /**
     * Activate account for trial and send email.
     * @param type $accountid company account id.
     */
    public function activateTrialOfAccount($accountid)
    {
        /* @var $ownerDetails \Ixoil\UserBundle\Entity\User */
        $ownerDetails = $this->getCompanyOwnerDetails($accountid);
        $ownerEmail = $ownerDetails->getEmail();
        
        // Unlock user account.
        $accountEntity = $ownerDetails->getAccount();
        $accountEntity->setIsLocked(0);
        $accountEntity->setStatus(AccountStatus::Accepted);
        $this->em->persist($accountEntity);
        $this->em->flush();

        $this->addTrialSubscriptionToAccount($accountEntity);
        
        // Send trial activated mail to company owner.
        $this->mailer->sendTwigEmail(
            $ownerEmail, 
            EmailType::AccountAccept, 
            array('name' => $ownerDetails->getFirstname())
        );
    }
    
    /**
     * Add Trial subscription Type
     * @param \Ixoil\UserBundle\Entity\Account $account
     */
    public function addTrialSubscriptionToAccount(Account $account )
    {
        $subscriptionType = SubscriptionType::Trial;
        $accountType = $account->getAccountType();
        
        $subscriptionCode = $this->getSubscriptionCode($accountType, $subscriptionType);

        // Set trial period start and end time.
        $startDate = new \DateTime();
        $endDate = new \DateTime();
        $period = '30'; // 30 days
        $endDate->modify('+'.$period.' day');
        
        // Get Subscription
        $subscription = $this->em->getRepository('IxoilUserBundle:Subscription')
                ->findOneByCode($subscriptionCode);
        
        // Populate Entity object.
        $subscriptionToAccount = new SubscriptionToAccount();
        $subscriptionToAccount->setAccount($account);
        $subscriptionToAccount->setSubscription($subscription);
        $subscriptionToAccount->setStartDate($startDate);
        $subscriptionToAccount->setEndDate($endDate);
        
        $this->em->persist($subscriptionToAccount);
        
        // Add entries to subscriptionOptionToAccount
        $subscriptionOptions = $subscription->getOptions();
        
        foreach($subscriptionOptions as $subscriptionOption)
        {
            $subscriptionOptionToAccount = new SubscriptionOptionToAccount();
            $subscriptionOptionToAccount->setAccount($account);
            $subscriptionOptionToAccount->setSubscriptionOption($subscriptionOption);
            $subscriptionOptionToAccount->setStartDate($startDate);
            $subscriptionOptionToAccount->setEndDate($endDate);
            $this->em->persist($subscriptionOptionToAccount);
        }
        
        $this->em->flush();
    }
    
    /**
     * Generate subscription code using accountyType and subscriptionType
     * @param string $accountType
     * @param string $subscriptionType
     * @return string subscriptionCode
     */
    public function getSubscriptionCode($accountType,$subscriptionType)
    {
        // Algo to generate code from account type and subscription type.
        return $accountType.'-'.$subscriptionType;
    }
    
    /**
     * set account status 'rejected' and send rejection mail.
     * @param integer $accountid company account id
     * @param string $emailBody email body
     */
    public function rejectAccount($accountid, $emailBody)
    {        
        // Get Owner Details.
        $ownerDetails = $this->getCompanyOwnerDetails($accountid);
        $ownerEmail = $ownerDetails->getEmail();
        
        // Set company status to 'rejected'
        $account = $ownerDetails->getAccount();
        $account->setStatus(AccountStatus::Refused);
        $this->em->persist($account);
        $this->em->flush();
        
        // Send Account rejected notification mail. 
        $this->sendSimpleEmail(
            $ownerEmail,
            $this->translator->trans('rejection_email.subject', array(), 'admin'),
            $emailBody
        );
    }
}

