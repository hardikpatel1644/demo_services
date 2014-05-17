<?php

namespace Ixoil\UserBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Ixoil\FileBundle\Model\FileType;

/**
 * Class RegistrationHandler
 * @package Ixoil\UserBundle\Form\Handler
 */
class RegistrationHandler
{

    /**
     * @var
     */
    protected $flow;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var
     */
    protected $model;

    /**
     * @var
     */
    protected $form;

    /**
     *
     * @var type 
     */
    protected $uploader;
    
    /**
     *
     * @var type 
     */
    protected $formModel;
    
    /**
     *
     * @var type 
     */
    protected $fileManager;

    /**
     * @param $manager
     * @param $flow
     * @param Request $request
     */
    public function __construct($manager, $flow, Request $request, $fileManager)
    {
        $this->flow = $flow;
        $this->manager = $manager;
        $this->request = $request;
        $this->form = null;
        $this->formModel = null;
        $this->fileManager = $fileManager;
    }

    /**
     * Handle form
     *
     * @return int
     */
    public function process()
    {
        // Reset form
        $this->resetForm();

        // Bind model
        $this->formModel = $this->manager->getRegistrationModel();
        $this->flow->bind($this->formModel);
        $form = $this->getForm();

        // Check the method
        if ($this->request->isMethod('POST'))
        {
            if ($this->flow->isValid($form))
            {
                $this->onSuccess($form);
                return true;
            } else
            {
                return false;
            }
        }

        return false;
    }

    /**
     * @param $form
     */
    protected function onSuccess($form)
    {
        // Save current data
        $this->flow->saveCurrentStepData($form);

        // Save client filename
        $this->saveUploadedFilenames();
    }

    /**
     * @return mixed
     */
    public function getFlow()
    {
        return $this->flow;
    }

    public function resetForm()
    {
        $this->form = null;
    }
    
    /**
     * 
     */
    public function getFormModel()
    {
        return $this->formModel;
    }

    /**
     * @return mixed
     */
    public function getForm()
    {
        if (!$this->form)
            $this->form = $this->flow->createForm();

        return $this->form;
    }

    /**
     * @return mixed
     */
    public function isLastStep()
    {
        return $this->flow->getCurrentStepNumber() === $this->flow->getStepCount() - 1;
    }

    /**
     * 
     */
    protected function saveUploadedFilenames()
    {
        $parameters = $this->flow->getRequest()->files->all();

        if (count($parameters) > 0)
        {
            foreach ($parameters as $step => $parameter)
            {
                $arrSessionVal = array();
                foreach ($parameter as $control_name => $objUploadFile)
                {
                    $filename = $objUploadFile->getClientOriginalName();

                    // Move uploaded file to tmp
                    $ssNewFileName = $this->fileManager->getTemporaryName($filename, 3600 * 4);
                    $this->fileManager->moveUploaded($objUploadFile, FileType::tmp(), $ssNewFileName);

                    // Save original filename in session
                    $arrSessionVal[$control_name] = $filename;
                    $arrSessionVal[$control_name . "_new"] = $ssNewFileName;
                }
               $this->manager->saveRegistrationFilesToSession($step, $arrSessionVal);
            }
        }
    }
    
    public function clearFlowSession()
    {
        $flow = $this->getFlow();
        $flow->getStorage()->remove('flow_'.$flow->getName().'_data');
    }
}