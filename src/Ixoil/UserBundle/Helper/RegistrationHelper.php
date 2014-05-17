<?php

namespace Ixoil\UserBundle\Helper;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ixoil\HomeBundle\Form\Model\Registration;
use Ixoil\UserBundle\Model\AccountType;
use Ixoil\CoreBundle\Entity\Address;
use Ixoil\UserBundle\Entity\Account;
use Ixoil\CoreBundle\Entity\ProviderAccount;
use Ixoil\CoreBundle\Entity\PurchaserAccount;
use Ixoil\CoreBundle\Entity\LogisticianAccount;
use Ixoil\UserBundle\Model\AccountStatus;
use Ixoil\UserBundle\Entity\User;
use Ixoil\FileBundle\Model\FileType;
use Ixoil\EmailBundle\Model\EmailType;

/**
 * 
 */
class RegistrationHelper
{
    
    /**
     * 
     */
    const SessionEmail = 'ixoil_home.registration.email';
    
    /**
     * @var
     */
    const SessionType = 'ixoil_home.registration.type';
    
    /**
     * @var
     */
    const SessionFiles = 'ixoil_home.registration.files';

    /**
     * @var
     */
    protected $session;

    /**
     * @var array
     */
    protected $models;

    /**
     *
     * @var type EntityManager
     */
    protected $em;
    
    /**
     *
     * @var type 
     */
    protected $fileManager;
    
    /**
     *
     * @var type 
     */
    protected $mailer;
    
    /**
     *
     * @var type 
     */
    protected $router;
    
    /**
     *
     * @var type 
     */
    protected $userManager;
    
    /**
     *
     * @var type 
     */
    protected $serviceContainer;
    
    /**
     * 
     * @param type $validator
     * @param type $session
     * @param type $models
     * @param type $entityManager
     * @param type $fileManager
     * @param type $container
     */
    public function __construct($session, $entityManager, $fileManager, $mailer, $router, $userManager, $container)
    {
        $this->models = array();
        
        $this->em = $entityManager;
        $this->session = $session;
        $this->em = $entityManager;
        $this->fileManager = $fileManager;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->userManager = $userManager;
        $this->serviceContainer = $container;
    }
    
    /**
     * 
     * @param string $model
     */
    public function setDefaultModel($model)
    {
        $this->models['default'] = $model;
    }
    
    public function setPurchaserModel($model)
    {
        $this->models[AccountType::Purchaser] = $model;
    }
    
    public function setProviderModel($model)
    {
        $this->models[AccountType::Provider] = $model;
    }
    
    public function setLogisticianModel($model)
    {
        $this->models[AccountType::Logistician] = $model;
    }
    
    public function setPurchaserLogisticianModel($model)
    {
        $this->models[AccountType::PurchaserLogistician] = $model;
    }

    /**
     * @param $type
     * @return bool
     */
    public function saveRegistrationType($type)
    {
        // Check type
        if(!array_key_exists($type, $this->models) || $type === 'default')
            return false;
        // Save type to session
        $this->session->set(self::SessionType, $type);
        return true;
    }

    /**
     * @param Registration $registrationData
     * @return bool
     */
    public function saveRegistration(Registration $registrationData)
    {
        // Put All thing in a transaction.
        $savedSuccess = true;

        try {
            $this->em->getConnection()->beginTransaction();
            
            // Populate All Entities
            $account = $this->populateEntitiesFromModel($registrationData);
            
            $savedSuccess &= ( $account != null );

            if ($savedSuccess) {
                $savedSuccess &= $this->moveFilesToAccountFolder(
                    array(
                        'bank_statement_new' => array(
                            'setFileBankStatement',
                            'bank_statement'
                        ),
                        'certificate_of_incorporation_new' => array(
                            'setFileCertificateIncorporation',
                            'certificate_incorporation'
                        ),
                    ),
                    $account
                );
            }

            // if any error in validation or file moving don't store data.
            if ($savedSuccess)
                $this->em->getConnection()->commit();
        } catch (Exception $e)
        {
            $this->em->getConnection()->rollback();
            $savedSuccess = false;
        }
        
        if ($savedSuccess)
            $this->setRegisteredEmail(strtolower($registrationData->getEmail()));
        
        return $savedSuccess;
    }

    /**
     * 
     * @param \Ixoil\HomeBundle\Form\Model\Registration $registrationData
     * @return type Ixoil\UserBundle\Entity\Account return Account object
     */
    private function populateEntitiesFromModel(Registration $registrationData)
    {
        // Populate address
        $address = new Address();
        $address->setStreet($registrationData->getAddress());
        $address->setCity($registrationData->getCity());
        $address->setZipCode($registrationData->getZipCode());
        $address->setCountry($registrationData->getCountry());
        $address->setFax($registrationData->getFax());
        $address->setPhone($registrationData->getPhoneNumber());

        $this->em->persist($address);
        $this->em->flush();
       
        // Get Bank Statements and Certification file names from session which moved in temp directory.
        $session_files = $this->getRegistrationFiles();
        $bank_statement = self::array_search_key('bank_statement_new',$session_files);
        $certificate_of_incorporation = self::array_search_key('certificate_of_incorporation_new',$session_files);
        
        // Populate Account Entity
        $account = new Account();
        $account->setAddress($address);
        $account->setName($registrationData->getCompanyName());
        $account->setIsLocked(false);
        $account->setStatus(AccountStatus::Unchecked);
        $account->setCompanyNumber($registrationData->getCompanyNumber());
        $account->setVatNumber($registrationData->getVAT());
        $account->setFileBankStatement($bank_statement);
        $account->setFileCertificateIncorporation($certificate_of_incorporation);
        $account->setTosVersion($this->getParameter('tos_version'));

        $this->em->persist($account);
        $this->em->flush();
        
        // Populate User Entity.
        // TODO: Set Proper default type for enabled,locked,expired, roles fields
        $tokenGenerator = $this->serviceContainer->get('fos_user.util.token_generator');
        $user = new User();
        $email = $registrationData->getEmail();
        $canonicalEmail = (strtolower($email));
        $user->setUsername($email);
        $user->setAccount($account);
        $user->setUsernameCanonical($canonicalEmail);
        $user->setEnabled(false);
        $user->setLocked(false);
        $user->setExpired(false);
        $user->setRoles(array('ROLE_USER'));
        $user->setEmail($email);
        $user->setEmailCanonical($canonicalEmail);
        $user->setPlainPassword($registrationData->getPassword());
        $user->setFirstname($registrationData->getFirstName());
        $user->setLastname($registrationData->getLastName());
        $user->setIsOwner(true);
        $user->setConfirmationToken($tokenGenerator->generateToken());
        
        $this->em->persist($user);
        
        // Populate specific informations
        switch ($this->getRegistrationType()) {
            case AccountType::Purchaser:
                $this->populatePurchaserAccount($account, $registrationData);
                break;
            
            case AccountType::Provider:
                $this->populateProviderAccount($account, $registrationData);
                break;
            
            case AccountType::Logistician:
                $this->populateLogisticianAccount($account, $registrationData);
                break;
            
            case AccountType::PurchaserLogistician:
                $this->populatePurchaserAccount($account, $registrationData);
                $this->populateLogisticianAccount($account, $registrationData);
                break;
        }
        
        // Flush everything
        $this->em->flush();
        
        return $account;
    }

    /**
     * 
     * @param type $account
     * @param \Ixoil\HomeBundle\Form\Model\Registration $data
     */
    protected function populatePurchaserAccount($account, Registration $data)
    {
        $purchaserAccount = new PurchaserAccount();
        $purchaserAccount->setAccount($account);
        $purchaserAccount->setActivities($data->getActivities());
        
        $this->em->persist($providerAccount);
    }
    
    /**
     * 
     * @param type $account
     * @param \Ixoil\HomeBundle\Form\Model\Registration $data
     */
    protected function populateProviderAccount($account, Registration $data)
    {
        $providerAccount = new ProviderAccount();
        $providerAccount->setAccount($account);
        $providerAccount->setActivities($data->getActivities());
        
        $this->em->persist($providerAccount);
    }
    
    /**
     * 
     * @param type $account
     * @param \Ixoil\HomeBundle\Form\Model\Registration $data
     */
    protected function populateLogisticianAccount($account, Registration $data)
    {
        $logisticianAccount = new LogisticianAccount();
        $logisticianAccount->setAccount($account);
        $logisticianAccount->setDeliveryAreas($data->getDeliveryAreas());
        
        $this->em->persist($logisticianAccount);
    }
    
    /**
     * @return null
     */
    public function getRegistrationType()
    {
        return ($this->session->has(self::SessionType) ?
            $this->session->get(self::SessionType) :
            null
        );
    }

    /**
     * @return mixed
     */
    public function getRegistrationModel()
    {
        // Get session type
        $type = $this->getRegistrationType();

        // Provide a default one if required
        if (!array_key_exists($type, $this->models))
            $type = 'default';

        return new $this->models[$type];
    }
    
    /**
     * 
     * @return type
     */
    protected function getRegistrationFiles()
    {
        $array = ($this->session->has(self::SessionFiles) ? 
            (array) $this->session->get(self::SessionFiles) :
            array()
        );
        return $array;
    }
    
    /**
     * 
     * @param type $key
     * @param type $values
     */
    public function saveRegistrationFilesToSession($key, $values)
    {
        $array = $this->getRegistrationFiles();
        $array[$key] = $values;
        $this->session->set(self::SessionFiles, $array);
    }
    
    /**
     * 
     * @param type $needle_key
     * @param type $array
     * @return boolean
     */
    public static function array_search_key($needle_key, $array)
    {
        if (count($array) > 0 && !empty($array)) {
            foreach ($array as $key => $value) {
                if ($key == $needle_key)
                    return $value;
                if (is_array($value) && ($result = self::array_search_key($needle_key, $value)) !== false)
                    return $result;
            }
        }
        return false;
    }

    /**
     * 
     */
    public function clearRegistrationFilesSession()
    {
        $this->session->remove(self::SessionFiles);
    }
    
    /**
     * 
     * @param array $arrFileNames
     * @param \Ixoil\UserBundle\Entity\Account $account
     * @return boolean ,if all files moved return true, else false.
     */
    public function moveFilesToAccountFolder($arrFileNames, Account $account)
    {
        $moveAllSuccess = true;

        // Move bank statement and Certificated from tmp directory to account/{accountid} directory.
        if (count($arrFileNames) > 0) {
            $sessionFiles = $this->getRegistrationFiles();

            foreach ($arrFileNames as $sessionName => $fileInfos) {
                $methodName = $fileInfos[0];
                $simpleName = $fileInfos[1];

                try {
                    // Get saved filename
                    $fileName = self::array_search_key($sessionName, $sessionFiles);

                    // Prepare new filename and store it
                    $newName = $simpleName . $this->fileManager->guessExtension($fileName);

                    // Move file
                    $this->fileManager->move(FileType::tmp(), $fileName, FileType::account($account), $newName);

                    // Save new name to account
                    $account->{$methodName}($newName);
                } catch (Exception $e) {
                    $moveAllSuccess = false;
                }
            }
        }

        if ($moveAllSuccess) {
            $this->em->persist($account);
            $this->em->flush();
        }

        return $moveAllSuccess;
    }
    
    /**
     * 
     * @return type
     */
    public function getRegisteredEmail()
    {
        return ($this->session->has(self::SessionEmail) ? $this->session->get(self::SessionEmail) : null);
    }
    
    /**
     * 
     * @param $user
     */
    protected function setRegisteredEmail($user)
    {
        $this->session->set(self::SessionEmail, $user);
    }
    
    /**
     * 
     */
    public function removeRegisteredEmail()
    {
        if ($this->session->has(self::SessionEmail))
           $this->session->remove(self::SessionEmail);
    }
    
    /**
     * To get parameter set in parameter.
     * @param type $parameter
     * @return type
     */
    public function getParameter($parameter)
    {
        return $this->serviceContainer->getParameter($parameter);
    }
    
    public function sendConfirmationMail()
    {
        // Get user email
        $email = $this->getRegisteredEmail();
        
        if ($email != null) {
            // Get user object
            $user = $this->userManager->findUserByUsernameOrEmail($email);
            if($user === null)
                throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));

            // Get email verification URL
            $url = $this->router->generate(
                'ixoil_registration_confirmemail', 
                array('token' => $user->getConfirmationToken()), 
                true
            );

            // Send confirmation email
            $this->mailer->sendTwigEmail(
                $user->getEmail(), 
                EmailType::ConfirmationEmail, 
                array('name' => $user->getFirstname(), 'confirmation_url' => $url)
            );
        }
    }
}