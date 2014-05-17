<?php

namespace Ixoil\UserBundle\Admin;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Ixoil\UserBundle\Model\AccountType;
use Ixoil\UserBundle\Model\AccountStatus;
use Ixoil\UserBundle\Model\PurchaserActivity;
use Ixoil\UserBundle\Model\ProviderActivity;
use Ixoil\FileBundle\Model\FileType;

/**
 * Description of AccountAdmin
 *
 * @author OXIND
 */
class AccountAdmin extends Admin
{   
    /*
     * Set translation domain for whole company management in admin area
     * @var string
     */
    protected $translationDomain = 'admin';
    
    /*
     * File Manager
     * @var object \Ixoil\FileBundle\Manager\FileManager
     */
    protected $fileManager;
    
    /**
     *
     * @var type 
     */
    protected $bank_statement;
    protected $certificate_incorporation;


    /**
     * Constructor with optional parameters
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * $param object $fileManager
     */
    public function __construct($code, $class, $baseControllerName, $fileManager)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->fileManager = $fileManager;
    }
    
    /**
     * configure options
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->clearExcept(array('list', 'edit', 'show'));
        $collection->add('download','download/{accountid}/{filename}');
        $collection->add('viewFile','viewfile/{accountid}/{filename}');
        $collection->add('activateTrial','activatetrial/{accountid}');
        $collection->add('rejectAccount','rejectaccount/{accountid}');
    }
    
    /**
     * Function to list all fields
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            
            ->addIdentifier('name', null, array('label'=>'company.name'))
            ->add('company_number', null, array('label'=>'company.number'))
            ->add(
                'address.country', 
                'string', 
                array(
                    'label' => 'company.address.country',
                    'template' => 'IxoilUserBundle:Admin:country_list_field.html.twig',
                )
            )
            ->add(
                'accountType',
                null,
                array(
                    'label'=>'company.account_type',
                )
            )
            ->add(
                'status',
                'boolean',
                array(
                    'editable' => true,
                    'template' => 'IxoilUserBundle:Admin:custom_list_status.html.twig',
                    'label' => 'company.status.title'
                )
            )
            ->add(
                'is_locked',
                null,
                array(
                    'editable' => true,
                    'template' => 'IxoilUserBundle:Admin:custom_list_is_locked.html.twig',
                    'label'=>'company.is_locked',
                )
            )
            ->addIdentifier(
                'users', 
                null, 
                array(
                    'label' => 'company.owner',
                    'template' => 'IxoilUserBundle:Admin:custom_list_is_owner.html.twig',
                    'route' => array('name' => 'show')
                )
            )
            ->add(
                '_action',
                'actions', 
                array(
                    'label' => 'company.action_label',
                    'actions' => array('show' => array())
                )
            )
        ;
    }
    
    /**
     * Function to filter fields
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array( 'label' => 'company.name'))
            ->add('company_number', null, array( 'label' => 'company.number'))
        ;
    }
    
    /**
     * Function to show all fields
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        // Prepare user's files URL.
        /* @var $objAccount \Ixoil\UserBundle\Entity\Account */
        $objAccount = $this->getSubject();
        $bankStatementURL = $this->generateUrl('viewFile', 
                array('accountid'=>$objAccount->getId(),'filename'=>$objAccount->getFileBankStatement()),  
                UrlGeneratorInterface::ABSOLUTE_URL  );
        $certIncorpURL = $this->generateUrl('viewFile', 
                array('accountid'=>$objAccount->getId(),'filename'=>$objAccount->getFileCertificateIncorporation()),  
                UrlGeneratorInterface::ABSOLUTE_URL  );
        
        $downloadBankStatementURL = $this->generateUrl('download', 
                array('accountid'=>$objAccount->getId(),'filename'=>$objAccount->getFileBankStatement()),  
                UrlGeneratorInterface::ABSOLUTE_URL  );
        $downloadCertIncorpURL = $this->generateUrl('download', 
                array('accountid'=>$objAccount->getId(),'filename'=>$objAccount->getFileCertificateIncorporation()),  
                UrlGeneratorInterface::ABSOLUTE_URL  );

        $showMapper
            
            ->with('company.heading.general')
                ->add('name', null, array('label'=>'company.name'))
                ->add('company_number', null, array('label'=>'company.number'))
                ->add('vat_number', null, array('label'=>'company.vat_number'))
                ->add(
                    'accountType',
                    null,
                    array(
                        'label' => 'company.account_type',
                    )
                )
                ->add(
                    'file_bank_statement', 
                    null, 
                    array(
                        'label' => 'company.bank_statement',
                        'template' => 'IxoilUserBundle:Admin:custom_show_link.html.twig',
                        'target' => '_blank',
                        'text' => 'company.view_bank_statement',
                        'url' => $bankStatementURL,
                        'btn_download' =>array( 'url'=> $downloadBankStatementURL,'text'=>'download')
                    )
                )
                ->add(
                    'file_certificate_incorporation', 
                    null, 
                    array(
                        'label' => 'company.certificate_of_incorporation',
                        'template' => 'IxoilUserBundle:Admin:custom_show_link.html.twig',
                        'target' => '_blank',
                        'text' => 'company.view_certificate_of_incorporation',
                        'url' => $certIncorpURL,
                        'btn_download' =>array( 'url'=> $downloadCertIncorpURL,'text'=>'download')
                    )
                )
            ->end()
            
            ->with('company.account_type_info')
                ->add(
                    'getAccountType',
                    null,
                    array(
                        'label'=>'Activities',
                        'template' => 'IxoilUserBundle:Admin:custom_show_account_type_info.html.twig',
                    )
                )
           ->end()
            // Users list for same company
            ->with('company.heading.company_user_list')
                ->add(
                    'users',
                    null,
                    array(
                        'label' => 'company.users',
                        'route' => array('name' => 'show'),
                        'template' => 'IxoilUserBundle:Admin:custom_show_users.html.twig',
                    )
                )
            ->end()
            
            ->with('company.heading.address')
                ->add('address.street', null, array('label'=>'company.address.street'))
                ->add('address.zip_code', null, array('label'=>'company.address.zip_code'))
                ->add('address.city', null, array('label'=>'company.address.city'))
                ->add(
                    'address.country', 
                    null, 
                    array(
                        'label'=>'company.address.country',
                        'template' => 'IxoilUserBundle:Admin:country_show_field.html.twig',
                    )
                )
                ->add('address.phone', null, array('label'=>'company.address.phone'))
            ->end()
        ;
        
        // If Account is not approved, show Accept and Reject Buttons.
        if($objAccount->getStatus() === AccountStatus::Unchecked || $objAccount->getStatus() === AccountStatus::Pending)
        {
            $trialActivationURL = $this->generateUrl(
                'activateTrial', 
                array('accountid'=>$objAccount->getId()),  
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            
            $showMapper
                ->with('company.heading.action_required')
                    ->add(
                        'is_locked',
                        null, 
                        array(
                            'label' => 'company.action_label',
                            'template' => 'IxoilUserBundle:Admin:custom_show_button.html.twig',
                            'btnactive'=>array('text' => 'company.action.activate','url' => $trialActivationURL),
                            'btnreject'=>array('text' => 'company.action.reject','url' => '#')
                        )
                    )
                ->end();
        }
    }
    
    /**
     * Function to edit all fields
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // Prepare user's files URL.
        /* @var $objAccount \Ixoil\UserBundle\Entity\Account */
        $objAccount = $this->getSubject();        
        
        // Generate Url link for view document
        $bankStatementURL = $this->generateUrl(
            'viewFile', 
            array(
                'accountid' => $objAccount->getId(),
                'filename' => $objAccount->getFileBankStatement()
            ),  
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $certIncorpURL = $this->generateUrl(
            'viewFile', 
            array(
                'accountid' => $objAccount->getId(),
                'filename' => $objAccount->getFileCertificateIncorporation()
            ),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        
        //Generate download link for documents
        $downloadBankStatementURL = $this->generateUrl(
            'download', 
            array(
                'accountid' => $objAccount->getId(),
                'filename' => $objAccount->getFileBankStatement()
            ),  
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $downloadCertIncorpURL = $this->generateUrl(
            'download', 
            array(
                'accountid' => $objAccount->getId(),
                'filename' => $objAccount->getFileCertificateIncorporation()
            ),  
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        
        // to save file names
        $this->getOldDocumentNames($objAccount);
        
        // get account type
        $accountType = $objAccount->getAccountType();
        
        $formMapper
            ->with('company.heading.general')
                ->add('name', null, array('label'=>'company.name'))
                ->add('company_number', null, array('label'=>'company.number'))
                ->add('vat_number', null, array('label'=>'company.vat_number'))
            ->end()
                
            ->with('company.heading.address')
                ->add('address.street', null, array('label'=>'company.address.street'))
                ->add('address.zip_code', null, array('label'=>'company.address.zip_code'))
                ->add('address.city', null, array('label'=>'company.address.city'))
                ->add('address.country', 'country', array('label'=>'company.address.country'))
                ->add('address.phone', null, array('label'=>'company.address.phone'))
                ->add(
                    'address.phone_alt', 
                    null, 
                    array(
                        'label' => 'company.address.phone_alt', 
                        'required' => false
                    )
                )
                ->add('address.fax', null, array('label'=>'company.address.fax'))
            ->end()
            
            ->with('company.account_type_info')
                // Add document upload field with view & download link for previous document
                ->add(
                    'file_bank_statement', 
                    'file',
                    array(
                        'label' => 'company.file_certificate_incorporation', 
                        'required' => false, 
                        'data_class'=> null,
                        'help' => 
                            '<a href="'.$bankStatementURL.'" target="_blank">' . $this->trans('company.view_bank_statement').'</a> ' .
                            '<a href="'.$downloadBankStatementURL.'" class="btn">Download</a>',
                    )
                )
                ->add(
                    'file_certificate_incorporation', 
                    'file', 
                    array(
                        'label' => 'company.file_certificate_incorporation', 
                        'required' => false, 
                        'data_class'=> null,
                        'help' => '<a href="'.$certIncorpURL.'" target="_blank">'.$this->trans('company.file_certificate_incorporation').'</a> <a href="'.$downloadCertIncorpURL.'" class="btn">Download</a>',
                    )
                );
        
            if($accountType == AccountType::Purchaser) {
                $this->getPurchaserActivities($formMapper);
            }
            if($accountType == AccountType::Provider) {
                $this->getProviderActivities($formMapper);
            }
            if($accountType == AccountType::Logistician) {
                $this->getDeliveryAreas($formMapper);
            }
            if($accountType == AccountType::PurchaserLogistician) {
                $this->getPurchaserActivities($formMapper, 'purchaserAccount.activities');

                $this->getDeliveryAreas($formMapper);
            }
        $formMapper->end();
        
        // Subscription/activation management
        $formMapper
            ->with('company.heading.activation')
                ->add(
                    'is_locked', 
                    null, 
                    array(
                        'label' => 'company.is_locked', 
                        'translation_domain' => 'admin',
                        'required' => false
                    )
                )
                ->add(
                    'status', 
                    'choice', 
                    array(
                        'choices' => array(
                            AccountStatus::Unchecked => $this->trans('model.account.status.unchecked', array(), 'core'),
                            AccountStatus::Refused => $this->trans('model.account.status.refused', array(), 'core'),
                            AccountStatus::Pending => $this->trans('model.account.status.pending', array(), 'core'),
                            AccountStatus::Accepted => $this->trans('model.account.status.accepted', array(), 'core'),
                        ),
                        'label' => 'company.status.title', 
                        'translation_domain' => 'admin'
                    )
                )
            ->end();
    }

    /**
     * Set purchaser activities choices
     *
     * @access  protected
     * @param   array $formMapper
     * @return  void
     */

    protected function getPurchaserActivities($formMapper)
    {
        $formMapper
                ->add('purchaserAccount.activities', 'choice' ,
                    array(
                        'label' => 'company.activity',
                        'multiple' => true,
                        'expanded' => true,
                        'choices' => array(
                            PurchaserActivity::FreightTransport => $this->trans('model.purchaser.activity.freighttransport', array(), 'core'),
                            PurchaserActivity::PassengerTransport => $this->trans('model.purchaser.activity.passengertransport', array(), 'core'),
                            PurchaserActivity::ServiceStation => $this->trans('model.purchaser.activity.servicestation', array(), 'core'),
                            PurchaserActivity::Dealer => $this->trans('model.purchaser.activity.dealer', array(), 'core'),
                        ),
                    )
                );
    }
    
    protected function getProviderActivities($formMapper)
    {
        $formMapper 
                
            ->add(
                'providerAccount.activities', 
                'choice' ,
                array(
                    'label' => 'company.activity',
                    'multiple' => true,
                    'expanded' => true,
                    'choices' => array(
                        ProviderActivity::Tanker => $this->trans('model.provider.activity.tanker', array(), 'core'),
                        ProviderActivity::Dealer => $this->trans('model.provider.activity.dealer', array(), 'core'),
                        ProviderActivity::Merkant => $this->trans('model.provider.activity.merkant', array(), 'core'),
                        ProviderActivity::GMS => $this->trans('model.provider.activity.lms', array(), 'core'),
                    ),
                )
            );
    }
    
    protected function getDeliveryAreas($formMapper)
    {
        $formMapper 
                
            ->add('logisticianAccount.delivery_areas' , 'jvectormap',
                    array(
                        'label' => 'company.delivery_areas',
                    )
                );
    }
    
    public function preUpdate($account) {
        $files = $this->getRequest()->files->all();
        
        if(count($files) > 0)
        {
            $this->manageFileUpload($account);
        }
    }
    /*
     * set old document values to persist when empty documents
     * @param $account object
     */
    public function getOldDocumentNames($account)
    {
        $this->bank_statement = $account->getFileBankStatement();
        $this->certificate_incorporation = $account->getFileCertificateIncorporation();
    }
    
    public function manageFileUpload($account) {           
        
        $arrFileNames = array(
                     'bank_statement_new' => array(
                         'setFileBankStatement',
                         'bank_statement',
                         'getFileBankStatement'
                     ),
                     'certificate_of_incorporation_new' => array(
                         'setFileCertificateIncorporation',
                         'certificate_incorporation',
                         'getFileCertificateIncorporation'
                     ),
                 );

         foreach ($arrFileNames as $Name => $fileInfos) {
            $setMethod = $fileInfos[0];
            $simpleName = $fileInfos[1];
            $getMethod = $fileInfos[2];

             if ($account->$getMethod())
             {
                 // update the Image to trigger file management
                 $randName = $this->fileManager->generateRandomString();
                 
                 // Get saved filename
                 $fileName = $account->$getMethod()->getClientOriginalName();
                 
                 // Prepare new filename and store it
                 $newName = $simpleName . $this->fileManager->guessExtension($fileName);
                 
                 // Move file
                 $this->fileManager->moveUploaded($account->$getMethod(), FileType::account($account), $newName);
                 
                 // Save new name to account
                 $account->$setMethod($newName);
             } elseif (!$account->$getMethod())
             {
                 // prevent Sonata trying to persist an empty data
                 $account->$setMethod($this->$simpleName);
             }
        }
    }
    
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'IxoilUserBundle:Admin:custom_template_with_js.html.twig';
            default:
                return parent::getTemplate($name);
        }
    }
}